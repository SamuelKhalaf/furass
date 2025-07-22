<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Program;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConsultantDashboardController extends Controller
{
    public function index()
    {
        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();

        $data = [
            // Basic statistics
            'totalStudents' => $this->getTotalStudentsCount($consultant),
            'upcomingSessions' => $this->getUpcomingSessionsCount($consultant),
            'completedSessions' => $this->getCompletedSessionsCount($consultant),

            // Recent consultations
            'recentConsultations' => $this->getRecentConsultations($consultant),

            // Student progress
            'studentProgress' => $this->getStudentProgressMetrics($consultant),

            // Program popularity among consultant's students
            'popularPrograms' => $this->getPopularPrograms($consultant),
        ];

        return view('admin.dashboards.consultant', $data);
    }

    private function getTotalStudentsCount($consultant)
    {
        return Student::whereHas('school.consultants', function($query) use ($consultant) {
            $query->where('consultant_id', $consultant->id);
        })->count();
    }

    private function getUpcomingSessionsCount($consultant)
    {
        return $consultant->consultations()
            ->where('status', 'pending')
            ->where('scheduled_at', '>=', Carbon::now())
            ->count();
    }

    private function getCompletedSessionsCount($consultant)
    {
        return $consultant->consultations()
            ->where('status', 'done')
            ->where('scheduled_at', '>=', Carbon::now()->subMonth())
            ->count();
    }

    private function getRecentConsultations($consultant)
    {
        return $consultant->consultations()
            ->with(['student.user', 'notes'])
            ->where('scheduled_at', '>=', Carbon::now()->subMonth())
            ->orderBy('scheduled_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($consultation) {
                return [
                    'id' => $consultation->id,
                    'student_name' => $consultation->student->user->name,
                    'date' => Carbon::parse($consultation->scheduled_at)->format('M d, Y H:i'),
                    'status' => $consultation->status,
                    'has_notes' => $consultation->notes->isNotEmpty(),
                ];
            });
    }

    private function getStudentProgressMetrics($consultant)
    {
        $students = Student::whereHas('school.consultants', function($query) use ($consultant) {
            $query->where('consultant_id', $consultant->id);
        })
            ->withCount([
                'enrollments',
                'enrollments as active_enrollments' => function($query) {
                    $query->where('status', 'active');
                },
                'studentPathProgress as completed_paths' => function($query) {
                    $query->where('status', 3); // completed
                }
            ])->get();

        $totalStudents = $students->count();
        $activeStudents = $students->where('active_enrollments', '>', 0)->count();
        $progressingStudents = $students->where('completed_paths', '>', 0)->count();

        return [
            'total_students' => $totalStudents,
            'active_students' => $activeStudents,
            'progressing_students' => $progressingStudents,
            'active_percentage' => $this->calculatePercentage($activeStudents, $totalStudents),
            'progress_percentage' => $this->calculatePercentage($progressingStudents, $activeStudents),
        ];
    }

    private function getPopularPrograms($consultant)
    {
        return Program::select('programs.id', 'programs.title_ar', 'programs.title_en')
            ->selectRaw('COUNT(enrollments.id) as enrollment_count')
            ->join('enrollments', 'programs.id', '=', 'enrollments.program_id')
            ->whereHas('enrollments.student.school.consultants', function($query) use ($consultant) {
                $query->where('consultant_id', $consultant->id);
            })
            ->groupBy('programs.id', 'programs.title_ar', 'programs.title_en')
            ->orderByDesc('enrollment_count')
            ->limit(3)
            ->get()
            ->map(function ($program) {
                return [
                    'id' => $program->id,
                    'title' => app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en,
                    'enrollment_count' => $program->enrollment_count,
                ];
            });
    }

    private function calculatePercentage($value, $total)
    {
        return $total > 0 ? round(($value / $total) * 100, 1) : 0;
    }
}
