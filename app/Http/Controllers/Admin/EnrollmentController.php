<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentPathProgress;
use App\Services\IStudentProgressService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{

    protected IStudentProgressService $progressService;

    public function __construct(IStudentProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Display student enrolled programs
     */
    public function index()
    {
        $user = auth()->user();

        // Get the student model for this user
        $student = Student::where('user_id', $user->id)
            ->with(['enrollments.program'])
            ->first();

        $enrollments = $student ? $student->enrollments : collect();

        return view('admin.programs.student_enrollments', [
            'student' => $student,
            'enrollments' => $enrollments,
        ]);
    }

    /**
     * Show the program path and details for a student in a program
     */
    public function enrollmentShow($programId)
    {
        $user = auth()->user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $program = Program::findOrFail($programId);
        $enrollment = $student->enrollments()->where('program_id', $program->id)->first();

        // Get student's enrolled path points from student_path_progress
        // This ensures we show the path points as they were when the student enrolled
        $studentPathProgress = StudentPathProgress::where('student_id', $student->id)
            ->where('program_id', $program->id)
            ->with('pathPoint')
            ->get();

        // If no progress records exist, student hasn't been properly enrolled
        if ($studentPathProgress->isEmpty()) {
            return redirect()->route('admin.student.enrollments.index')
                ->with('error', __('No enrollment found for this program.'));
        }

        // Create path points collection from student's progress records
        $pathPointsWithProgress = $studentPathProgress->map(function ($progress) {
            $pathPoint = $progress->pathPoint;
            $pathPoint->progress = $progress;
            $pathPoint->status = $progress->status;
            $pathPoint->completion_date = $progress->completion_date;
            $pathPoint->score = $progress->score;
            $pathPoint->attempt_count = $progress->attempt_count;
            $pathPoint->time_spent = $progress->time_spent;
            $pathPoint->order = $progress->order ?? 1; // Use stored order from progress

            return $pathPoint;
        })->sortBy('order');

        $this->progressService->updateProgramProgress($student->id, $program->id);
        $enrollment->refresh();
        $overallProgress = $enrollment->progress;

        return view('admin.programs.student_program_show', [
            'student' => $student,
            'program' => $program,
            'enrollment' => $enrollment,
            'pathPoints' => $pathPointsWithProgress,
            'overallProgress' => $overallProgress,
        ]);
    }

    /**
     * Show specific path point activity
     */
    public function showPathPointActivity($programId, $pathPointId)
    {
        $user = auth()->user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $program = Program::findOrFail($programId);

        // Get student progress for this path point
        $progress = StudentPathProgress::where('student_id', $student->id)
            ->where('program_id', $program->id)
            ->where('path_point_id', $pathPointId)
            ->with('pathPoint')
            ->first();

        if (!$progress) {
            return redirect()->route('admin.student.enrollments.show', $programId)
                ->with('error', __('Path point not found in your enrollment.'));
        }

        $pathPoint = $progress->pathPoint;

        // Check if this path point is accessible (active or completed)
        if ($progress->status == 1) { // 1=locked
            return redirect()->route('admin.student.enrollments.show', $programId)
                ->with('error', __('This path point is not yet available.'));
        }

        $consultation = \App\Models\Consultation::where('student_id', $student->id)
            ->where('updated_at', '>=' , $progress->updated_at)
            ->latest()
            ->first();

        return view('admin.programs.student_path_point_activity', [
            'student' => $student,
            'program' => $program,
            'pathPoint' => $pathPoint,
            'progress' => $progress,
            'consultation' => $consultation,
        ]);
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function showProgramAssignment(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $school = School::where('user_id', auth()->id())->first();

        $students = Student::with(['user', 'enrollments.program'])
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('students.school_id', $school->id)
            ->orderBy('students.grade')
            ->orderBy('users.name')
            ->select('students.*')
            ->get();

        $programs = Program::orderBy(app()->getLocale() == 'ar' ? 'title_ar' : 'title_en')
            ->get();

        return view('admin.enrollment.index', [
            'students' => $students,
            'programs' => $programs,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function assignPrograms(Request $request): RedirectResponse
    {
        $request->validate([
            'programs' => 'required|array',
            'programs.*' => 'exists:programs,id',
            'students' => 'required_without:bulk_students|array',
            'bulk_students' => 'required_without:students|array',
        ]);

        $programIds = $request->input('programs');
        $studentIds = $request->input('students', []);
        $bulkStudentIds = $request->input('bulk_students', []);

        // Combine both student selection methods
        $allStudentIds = array_merge(
            array_keys($studentIds),
            $bulkStudentIds
        );

        if (empty($allStudentIds)) {
            return back()->with('error', __('No students selected for assignment.'));
        }

        DB::beginTransaction();
        try {
            foreach ($allStudentIds as $studentId) {
                foreach ($programIds as $programId) {
                    $existing = Enrollment::where('student_id', $studentId)
                        ->where('program_id', $programId)
                        ->first();

                    if (!$existing) {
                        $enrollment = Enrollment::create([
                            'student_id' => $studentId,
                            'program_id' => $programId,
                            'status' => 'active',
                            'progress' => 0,
                        ]);

                        // Initialize path progress for this student with CURRENT program structure
                        $this->initializeStudentPathProgress($studentId, $programId);
                    }
                }
            }

            DB::commit();
            return back()->with('success', __('Program assignments saved successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('Failed to save program assignments: ') . $e->getMessage());
        }
    }

    /**
     * Initialize student path progress when enrolled in a program
     * This captures the current state of the program's path points at enrollment time
     */
    private function initializeStudentPathProgress($studentId, $programId)
    {
        $program = Program::with(['pathPoints' => function($q) {
            $q->orderBy('path_point_program.order');
        }])->find($programId);

        if ($program && $program->pathPoints->count() > 0) {
            $pathPoints = $program->pathPoints;

            foreach ($pathPoints as $index => $pathPoint) {
                // The First path point is active (2), others are locked (1)
                $status = $index === 0 ? 2 : 1;

                StudentPathProgress::create([
                    'student_id' => $studentId,
                    'program_id' => $programId,
                    'path_point_id' => $pathPoint->id,
                    'status' => $status,
                    'completion_date' => null,
                    'score' => null,
                    'attempt_count' => 0,
                    'time_spent' => 0,
                    'order' => $pathPoint->pivot->order,
                ]);
            }
        }
    }

    /**
     * Helper method to check if a student's path structure needs updating
     * This should only be called in special circumstances (optional)
     */
    public function checkStudentPathStructure($studentId, $programId)
    {
        $currentProgramPaths = Program::with('pathPoints')->find($programId)->pathPoints->pluck('id');
        $studentPaths = StudentPathProgress::where('student_id', $studentId)
            ->where('program_id', $programId)
            ->pluck('path_point_id');

        // Check if student has path points that no longer exist in the program
        $removedPaths = $studentPaths->diff($currentProgramPaths);
        $newPaths = $currentProgramPaths->diff($studentPaths);

        return [
            'needs_update' => $removedPaths->isNotEmpty() || $newPaths->isNotEmpty(),
            'removed_paths' => $removedPaths,
            'new_paths' => $newPaths,
        ];
    }

    /**
     * Force update a student's path structure (use with caution)
     * This should only be used in exceptional cases
     */
    public function forceUpdateStudentPath($studentId, $programId)
    {
        DB::beginTransaction();
        try {
            // Get current student progress
            $currentProgress = StudentPathProgress::where('student_id', $studentId)
                ->where('program_id', $programId)
                ->get()
                ->keyBy('path_point_id');

            // Get current program structure
            $program = Program::with(['pathPoints' => function($q) {
                $q->orderBy('path_point_program.order');
            }])->find($programId);

            // Remove old progress records
            StudentPathProgress::where('student_id', $studentId)
                ->where('program_id', $programId)
                ->delete();

            // Recreate with current structure, preserving completed status where possible
            foreach ($program->pathPoints as $index => $pathPoint) {
                $oldProgress = $currentProgress->get($pathPoint->id);

                StudentPathProgress::create([
                    'student_id' => $studentId,
                    'program_id' => $programId,
                    'path_point_id' => $pathPoint->id,
                    'status' => $oldProgress ? $oldProgress->status : ($index === 0 ? 2 : 1),
                    'completion_date' => $oldProgress ? $oldProgress->completion_date : null,
                    'score' => $oldProgress ? $oldProgress->score : null,
                    'attempt_count' => $oldProgress ? $oldProgress->attempt_count : 0,
                    'time_spent' => $oldProgress ? $oldProgress->time_spent : 0,
                    'order' => $pathPoint->pivot->order,
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
