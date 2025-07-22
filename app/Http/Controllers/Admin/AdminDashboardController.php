<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultant;
use App\Models\School;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\Event;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = $this->getAdminDashboardData();
        return view('admin.dashboards.admin', $data);
    }

    private function getAdminDashboardData()
    {
        return [
            // Basic counts
            'totalModerators' => User::whereIn('role', [RoleEnum::ADMIN, RoleEnum::SUB_ADMIN])->count(),
            'activeConsultants' => Consultant::count(),
            'registeredSchools' => School::count(),
            'totalStudents' => Student::count(),

            // Most desired programs
            'mostDesiredPrograms' => $this->getMostDesiredPrograms(),

            // Highest rated activities
            'highestRatedActivities' => $this->getHighestRatedActivities(),

            // Commitment metrics
            'commitmentMetrics' => $this->getCommitmentMetrics(),
        ];
    }

    private function getMostDesiredPrograms()
    {
        return Program::select('programs.id', 'programs.title_ar', 'programs.title_en')
            ->selectRaw('COUNT(enrollments.id) as enrollment_count')
            ->leftJoin('enrollments', 'programs.id', '=', 'enrollments.program_id')
            ->groupBy('programs.id', 'programs.title_ar', 'programs.title_en')
            ->orderByDesc('enrollment_count')
            ->limit(5)
            ->get()
            ->map(function ($program) {
                return [
                    'id' => $program->id,
                    'title' => app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en,
                    'enrollment_count' => $program->enrollment_count,
                    'percentage' => $this->calculatePercentage($program->enrollment_count, Enrollment::count())
                ];
            });
    }

    private function getHighestRatedActivities()
    {
        return Event::select('events.id', 'events.event_name', 'events.event_type')
            ->selectRaw('AVG(trip_evaluations.rating) as avg_rating')
            ->selectRaw('COUNT(trip_evaluations.id) as evaluation_count')
            ->leftJoin('trip_evaluations', 'events.id', '=', 'trip_evaluations.event_id')
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

    private function getCommitmentMetrics()
    {
        $currentMonth = Carbon::now()->startOfMonth();

        return [
            'schools' => $this->getSchoolCommitment(),
            'consultants' => $this->getConsultantCommitment($currentMonth),
            'students' => $this->getStudentCommitment($currentMonth),
        ];
    }

    private function getSchoolCommitment()
    {
        $totalSchools = School::count();

        // Schools with active students
        $activeSchools = School::whereHas('student', function ($query) {
            $query->whereHas('enrollments', function ($enrollmentQuery) {
                $enrollmentQuery->where('status', 'active');
            });
        })->count();

        // Schools with recent activity (students with progress in last 30 days)
        $recentlyActiveSchools = School::whereHas('student.studentPathProgress', function ($query) {
            $query->where('updated_at', '>=', Carbon::now()->subDays(30));
        })->count();

        return [
            'total' => $totalSchools,
            'active' => $activeSchools,
            'recently_active' => $recentlyActiveSchools,
            'commitment_rate' => $this->calculatePercentage($recentlyActiveSchools, $totalSchools),
            'activity_rate' => $this->calculatePercentage($activeSchools, $totalSchools)
        ];
    }

    private function getConsultantCommitment($currentMonth)
    {
        $totalConsultants = Consultant::count();

        // Consultants with consultations this month
        $activeConsultants = Consultant::whereHas('consultations', function ($query) use ($currentMonth) {
            $query->where('scheduled_at', '>=', $currentMonth)
                ->where('status', '!=', 'cancelled');
        })->count();

        // Consultants who completed consultations
        $completedConsultants = Consultant::whereHas('consultations', function ($query) use ($currentMonth) {
            $query->where('scheduled_at', '>=', $currentMonth)
                ->where('status', 'done');
        })->count();

        return [
            'total' => $totalConsultants,
            'active_this_month' => $activeConsultants,
            'completed_sessions' => $completedConsultants,
            'commitment_rate' => $this->calculatePercentage($completedConsultants, $activeConsultants),
            'activity_rate' => $this->calculatePercentage($activeConsultants, $totalConsultants)
        ];
    }

    private function getStudentCommitment($currentMonth)
    {
        $totalStudents = Student::count();

        // Students with active enrollments
        $activeStudents = Student::whereHas('enrollments', function ($query) {
            $query->where('status', 'active');
        })->count();

        // Students with recent progress
        $progressingStudents = Student::whereHas('studentPathProgress', function ($query) use ($currentMonth) {
            $query->where('updated_at', '>=', $currentMonth);
        })->count();

        // Students who attended events this month
        $attendingStudents = Student::whereHas('tripAttendances', function ($query) use ($currentMonth) {
            $query->where('recorded_at', '>=', $currentMonth)
                ->where('status', 'attended');
        })->count();

        return [
            'total' => $totalStudents,
            'active_enrollments' => $activeStudents,
            'making_progress' => $progressingStudents,
            'attending_events' => $attendingStudents,
            'commitment_rate' => $this->calculatePercentage($progressingStudents, $activeStudents),
            'engagement_rate' => $this->calculatePercentage($attendingStudents, $activeStudents)
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
