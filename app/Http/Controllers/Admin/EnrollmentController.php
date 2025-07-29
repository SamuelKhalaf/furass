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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        // Create a path points collection from student's progress records
        $pathPointsWithProgress = $studentPathProgress->map(function ($progress) use ($student) {
            $pathPoint = $progress->pathPoint;
            $pathPoint->progress = $progress;
            $pathPoint->status = $progress->status;
            $pathPoint->completion_date = $progress->completion_date;
            $pathPoint->score = $progress->score;
            $pathPoint->attempt_count = $progress->attempt_count;
            $pathPoint->time_spent = $progress->time_spent;
            $pathPoint->order = $progress->order ?? 1; // Use stored order from progress

            // Check if path point grade matches student's grade
            $pathPoint->is_grade_locked = false;
            $pathPoint->available_in_grade = null;
            $pathPoint->grade_lock_message = null;

            if ($pathPoint->grade && $student->grade < $pathPoint->grade) {
                $pathPoint->is_grade_locked = true;
                $pathPoint->available_in_grade = $pathPoint->grade;
                $pathPoint->grade_lock_message = __('This path point will be available in grade :grade', ['grade' => $pathPoint->grade]);

                // Override status to lock if grade doesn't match
                $pathPoint->status = 1; // Force locked status
            }

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

        // Check if this path point is grade-locked
        if ($pathPoint->grade && $student->grade < $pathPoint->grade) {
            return redirect()->route('admin.student.enrollments.show', $programId)
                ->with('error', __('This path point will be available in grade :grade', ['grade' => $pathPoint->grade]));
        }

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
     * and respects grade restrictions
     */
    private function initializeStudentPathProgress($studentId, $programId)
    {
        $student = Student::find($studentId);
        $program = Program::with(['pathPoints' => function($q) {
            $q->orderBy('path_point_program.order');
        }])->find($programId);

        if ($program && $program->pathPoints->count() > 0) {
            $pathPoints = $program->pathPoints;
            $firstAvailableFound = false;

            foreach ($pathPoints as $index => $pathPoint) {
                // Check if this path point is grade-restricted
                $isGradeLocked = $pathPoint->grade && $student->grade < $pathPoint->grade;

                // Determine status based on grade restrictions and order
                if ($isGradeLocked) {
                    // Grade-locked path points are always locked (1)
                    $status = 1;
                } else if (!$firstAvailableFound) {
                    // First available (not grade-locked) path point is active (2)
                    $status = 2;
                    $firstAvailableFound = true;
                } else {
                    // All other available path points are locked (1) until unlocked
                    $status = 1;
                }

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
     * Download certificate for completed program
     */
    public function downloadCertificate($programId)
    {
        $user = auth()->user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $program = Program::findOrFail($programId);
        $enrollment = $student->enrollments()->where('program_id', $program->id)->first();

        // Check if enrollment exists and is completed
        if (!$enrollment || $enrollment->status != 'attended' || $enrollment->progress < 100) {
            return redirect()->route('admin.student.enrollments.show', $programId)
                ->with('error', __('Certificate is only available for completed programs.'));
        }

        if ($program->title_en == 'Self Campus')
            $view = 'admin.certificates.self_campus';
        else if ($program->title_en == 'Explore Your Career')
            $view = 'admin.certificates.explore_your_career';
        else if ($program->title_en == 'Ready for The Future')
            $view = 'admin.certificates.ready_for_the_future';
        else
            $view = 'admin.certificates.self_campus';


        // Generate certificate PDF
        try {
            $pdf = PDF::loadView($view, [
                'student' => $student,
                'program' => $program,
                'enrollment' => $enrollment,
                'completion_date' => $enrollment->updated_at->format('F d, Y'),
            ]);

            $fileName = 'certificate-' . Str::slug($program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'}) . '.pdf';

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            return redirect()->route('admin.student.enrollments.show', $programId)
                ->with('error', __('Error generating certificate. Please try again later.'));
        }
    }
}
