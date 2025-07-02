<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Program;
use App\Models\School;
use App\Models\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
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
                        Enrollment::create([
                            'student_id' => $studentId,
                            'program_id' => $programId,
                            'status' => 'pending',
                            'progress' => 0,
                        ]);
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
}
