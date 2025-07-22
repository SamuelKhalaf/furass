<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Event;
use App\Models\Program;
use App\Models\School;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchoolDashboardController extends Controller
{
    public function index()
    {
        $schoolId = School::where('user_id', auth()->id())->first()->id;
        $data = $this->getSchoolDashboardData($schoolId);
        return view('admin.dashboards.school', $data);
    }

    private function getSchoolDashboardData($schoolId)
    {
        return [
            // Student status in the three programs
            'programsStatus' => $this->getProgramsStudentStatus($schoolId),

            // Interest distribution analysis
            'interestDistribution' => $this->getInterestDistribution($schoolId),

            // Activity evaluations
            'activityEvaluations' => $this->getActivityEvaluations($schoolId),

            // Participation rates
            'participationRates' => $this->getParticipationRates($schoolId),
        ];
    }

    private function getProgramsStudentStatus($schoolId)
    {
        $programs = Program::limit(3)->get();

        return $programs->map(function ($program) use ($schoolId) {
            $enrollments = Enrollment::where('program_id', $program->id)
                ->whereHas('student', function ($query) use ($schoolId) {
                    $query->where('school_id', $schoolId);
                })
                ->get();

            $totalStudents = $enrollments->count();

            return [
                'program_id' => $program->id,
                'program_name' => app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en,
                'total_students' => $totalStudents,
                'status_distribution' => [
                    'active' => $enrollments->where('status', 'active')->count(),
                    'completed' => $enrollments->where('status', 'attended')->count(),
                    'evaluated' => $enrollments->where('status', 'evaluated')->count(),
                    'skipped' => $enrollments->where('status', 'skipped')->count(),
                ],
                'progress_average' => $enrollments->avg('progress') ?? 0,
            ];
        });
    }

    private function getInterestDistribution($schoolId)
    {
        // Get student interests based on program enrollments
        $programEnrollments = Program::select('programs.id', 'programs.title_ar', 'programs.title_en')
            ->selectRaw('COUNT(enrollments.id) as enrollment_count')
            ->leftJoin('enrollments', 'programs.id', '=', 'enrollments.program_id')
            ->whereHas('enrollments.student', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->groupBy('programs.id', 'programs.title_ar', 'programs.title_en')
            ->orderByDesc('enrollment_count')
            ->get();

        $totalEnrollments = $programEnrollments->sum('enrollment_count');

        return $programEnrollments->map(function ($program) use ($totalEnrollments) {
            return [
                'program_id' => $program->id,
                'program_name' => app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en,
                'enrollment_count' => $program->enrollment_count,
                'percentage' => $totalEnrollments > 0 ? round(($program->enrollment_count / $totalEnrollments) * 100, 1) : 0
            ];
        });
    }

    private function getActivityEvaluations($schoolId)
    {
        return Event::select('events.id', 'events.event_name', 'events.event_type')
            ->selectRaw('AVG(trip_evaluations.rating) as avg_rating')
            ->selectRaw('COUNT(trip_evaluations.id) as evaluation_count')
            ->leftJoin('trip_evaluations', 'events.id', '=', 'trip_evaluations.event_id')
            ->whereHas('tripAttendances.student', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->groupBy('events.id', 'events.event_name', 'events.event_type')
            ->havingRaw('COUNT(trip_evaluations.id) > 0')
            ->orderByDesc('avg_rating')
            ->limit(5)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->event_name,
                    'type' => $event->event_type,
                    'avg_rating' => round($event->avg_rating, 2),
                    'evaluation_count' => $event->evaluation_count,
                    'rating_stars' => $this->generateStarRating($event->avg_rating)
                ];
            });
    }

    private function getParticipationRates($schoolId)
    {
        $totalStudents = Student::where('school_id', $schoolId)->count();

        // Students who attended any event
        $attendingStudents = Student::where('school_id', $schoolId)
            ->whereHas('tripAttendances', function ($query) {
                $query->where('status', 'attended');
            })
            ->count();

        // Students with active enrollments
        $activeStudents = Student::where('school_id', $schoolId)
            ->whereHas('enrollments', function ($query) {
                $query->where('status', 'active');
            })
            ->count();

        // Students with progress in a path
        $progressingStudents = Student::where('school_id', $schoolId)
            ->whereHas('studentPathProgress', function ($query) {
                $query->where('status', '!=', '1'); // Not locked
            })
            ->count();

        return [
            'total_students' => $totalStudents,
            'attending_students' => $attendingStudents,
            'active_students' => $activeStudents,
            'progressing_students' => $progressingStudents,
            'attendance_rate' => $this->calculatePercentage($attendingStudents, $totalStudents),
            'activity_rate' => $this->calculatePercentage($activeStudents, $totalStudents),
            'engagement_rate' => $this->calculatePercentage($progressingStudents, $totalStudents)
        ];
    }

    private function calculatePercentage($value, $total)
    {
        return $total > 0 ? round(($value / $total) * 100, 1) : 0;
    }

    private function generateStarRating($rating)
    {
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;

        return [
            'full' => $fullStars,
            'half' => $halfStar,
            'empty' => $emptyStars,
            'rating' => $rating
        ];
    }
}
