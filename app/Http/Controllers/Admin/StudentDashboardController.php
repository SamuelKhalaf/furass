<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Event;
use App\Models\TripEvaluation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            // Force logout due to incomplete account
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'An error occurred. Please try again.');
        }

        $data = $this->getStudentDashboardData($student);
        return view('admin.dashboards.student', $data);
    }

    private function getStudentDashboardData(Student $student)
    {
        return [
            // Basic student info and progress
            'student' => $student,
            'overallProgress' => $this->getOverallProgress($student),

            // Current enrollments and programs
            'currentEnrollments' => $this->getCurrentEnrollments($student),
            'completedPrograms' => $this->getCompletedPrograms($student),

            // Learning path progress
            'pathProgress' => $this->getPathProgress($student),
            'upcomingPathPoints' => $this->getUpcomingPathPoints($student),

            // Consultations
            'consultationStats' => $this->getConsultationStats($student),
            'upcomingConsultations' => $this->getUpcomingConsultations($student),

            // Events and activities
            'eventStats' => $this->getEventStats($student),
            'upcomingEvents' => $this->getUpcomingEvents($student),
            'recentEvaluations' => $this->getRecentEvaluations($student),

            // Performance metrics
            'performanceMetrics' => $this->getPerformanceMetrics($student),

            // Achievement summary
            'certificates' => $this->getAchievements($student),
        ];
    }

    private function getOverallProgress(Student $student)
    {
        $totalEnrollments = $student->enrollments()->count();
        $completedEnrollments = $student->enrollments()
            ->whereIn('status', ['attended', 'evaluated'])
            ->count();

        $totalPathPoints = $student->studentPathProgress()->count();
        $completedPathPoints = $student->studentPathProgress()
            ->where('status', 3) // completed
            ->count();

        return [
            'enrollment_completion_rate' => $totalEnrollments > 0 ?
                round(($completedEnrollments / $totalEnrollments) * 100, 1) : 0,
            'path_completion_rate' => $totalPathPoints > 0 ?
                round(($completedPathPoints / $totalPathPoints) * 100, 1) : 0,
            'total_enrollments' => $totalEnrollments,
            'completed_enrollments' => $completedEnrollments,
            'total_path_points' => $totalPathPoints,
            'completed_path_points' => $completedPathPoints,
        ];
    }

    private function getCurrentEnrollments(Student $student)
    {
        return $student->enrollments()
            ->with(['program'])
            ->where('status', 'active')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'program_title' => app()->getLocale() == 'ar' ?
                        $enrollment->program->title_ar : $enrollment->program->title_en,
                    'program_description' => app()->getLocale() == 'ar' ?
                        $enrollment->program->description_ar : $enrollment->program->description_en,
                    'progress' => $enrollment->progress,
                    'status' => $enrollment->status,
                    'enrolled_at' => $enrollment->created_at,
                ];
            });
    }

    private function getCompletedPrograms(Student $student)
    {
        return $student->enrollments()
            ->with(['program'])
            ->whereIn('status', ['attended', 'evaluated'])
            ->get()
            ->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'program_title' => app()->getLocale() == 'ar' ?
                        $enrollment->program->title_ar : $enrollment->program->title_en,
                    'status' => $enrollment->status,
                    'progress' => $enrollment->progress,
                    'completed_at' => $enrollment->updated_at,
                ];
            });
    }

    private function getPathProgress(Student $student)
    {
        $pathProgress = $student->studentPathProgress()
            ->with(['pathPoint', 'program'])
            ->orderBy('order')
            ->get()
            ->groupBy('program_id')
            ->map(function ($programProgress, $programId) {
                $program = $programProgress->first()->program;
                $totalPoints = $programProgress->count();
                $completedPoints = $programProgress->where('status', 3)->count();
                $activePoints = $programProgress->where('status', 2)->count();

                return [
                    'program_id' => $programId,
                    'program_title' => app()->getLocale() == 'ar' ?
                        $program->title_ar : $program->title_en,
                    'total_points' => $totalPoints,
                    'completed_points' => $completedPoints,
                    'active_points' => $activePoints,
                    'completion_rate' => $totalPoints > 0 ?
                        round(($completedPoints / $totalPoints) * 100, 1) : 0,
                    'total_time_spent' => $programProgress->sum('time_spent'),
                    'total_attempts' => $programProgress->sum('attempt_count'),
                    'points' => $programProgress->map(function ($point) {
                        return [
                            'id' => $point->id,
                            'title' => app()->getLocale() == 'ar' ?
                                $point->pathPoint->title_ar : $point->pathPoint->title_en,
                            'status' => $point->status,
                            'order' => $point->order,
                            'completion_date' => $point->completion_date,
                            'time_spent' => $point->time_spent,
                            'attempt_count' => $point->attempt_count,
                        ];
                    })->values(),
                ];
            });

        return $pathProgress;
    }

    private function getUpcomingPathPoints(Student $student)
    {
        return $student->studentPathProgress()
            ->with(['pathPoint', 'program'])
            ->where('status', 2) // active
            ->orderBy('order')
            ->limit(5)
            ->get()
            ->map(function ($point) {
                return [
                    'id' => $point->id,
                    'title' => app()->getLocale() == 'ar' ?
                        $point->pathPoint->title_ar : $point->pathPoint->title_en,
                    'program_title' => app()->getLocale() == 'ar' ?
                        $point->program->title_ar : $point->program->title_en,
                    'order' => $point->order,
                    'table_name' => $point->pathPoint->table_name,
                    'grade' => $point->pathPoint->grade,
                ];
            });
    }

    private function getConsultationStats(Student $student)
    {
        $total = $student->consultations()->count();
        $completed = $student->consultations()->where('status', 'done')->count();
        $pending = $student->consultations()->where('status', 'pending')->count();
        $cancelled = $student->consultations()->where('status', 'cancelled')->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending,
            'cancelled' => $cancelled,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
        ];
    }

    private function getUpcomingConsultations(Student $student)
    {
        return $student->consultations()
            ->with(['consultant.user'])
            ->where('status', 'pending')
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->limit(3)
            ->get()
            ->map(function ($consultation) {
                return [
                    'id' => $consultation->id,
                    'consultant_name' => $consultation->consultant->user->name,
                    'scheduled_at' => $consultation->scheduled_at,
                    'zoom_join_url' => $consultation->zoom_join_url,
                    'status' => $consultation->status,
                ];
            });
    }

    private function getEventStats(Student $student)
    {
        $totalAttendances = $student->tripAttendances()->count();
        $attended = $student->tripAttendances()->where('status', 'attended')->count();
        $absent = $student->tripAttendances()->where('status', 'absent')->count();

        $totalEvaluations = $student->tripEvaluations()->count();
        $avgRating = $student->tripEvaluations()->avg('rating');

        return [
            'total_events' => $totalAttendances,
            'attended' => $attended,
            'absent' => $absent,
            'attendance_rate' => $totalAttendances > 0 ?
                round(($attended / $totalAttendances) * 100, 1) : 0,
            'total_evaluations' => $totalEvaluations,
            'avg_rating' => $avgRating ? round($avgRating, 2) : 0,
        ];
    }

    private function getUpcomingEvents(Student $student)
    {
        // Get events for programs the student is enrolled in
        $enrolledProgramIds = $student->enrollments()
            ->where('status', 'active')
            ->pluck('program_id');

        return Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(3)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->event_name,
                    'type' => $event->event_type,
                    'location' => $event->location,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'description' => $event->description,
                ];
            });
    }

    private function getRecentEvaluations(Student $student)
    {
        return $student->tripEvaluations()
            ->with(['event'])
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->map(function ($evaluation) {
                return [
                    'id' => $evaluation->id,
                    'event_name' => $evaluation->event->event_name,
                    'event_type' => $evaluation->event->event_type,
                    'rating' => $evaluation->rating,
                    'feedback' => $evaluation->feedback,
                    'learning_outcomes' => $evaluation->learning_outcomes,
                    'created_at' => $evaluation->created_at,
                ];
            });
    }

    private function getPerformanceMetrics(Student $student)
    {
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // Progress this month
        $progressThisMonth = $student->studentPathProgress()
            ->where('updated_at', '>=', $thisMonth)
            ->where('status', 3) // completed
            ->count();

        $progressLastMonth = $student->studentPathProgress()
            ->where('updated_at', '>=', $lastMonth)
            ->where('updated_at', '<', $thisMonth)
            ->where('status', 3)
            ->count();

        // Consultations this month
        $consultationsThisMonth = $student->consultations()
            ->where('created_at', '>=', $thisMonth)
            ->where('status', 'done')
            ->count();

        // Events attended this month
        $eventsThisMonth = $student->tripAttendances()
            ->where('recorded_at', '>=', $thisMonth)
            ->where('status', 'attended')
            ->count();

        $totalTests = DB::table('evaluation_tests')
            ->where('student_id', $student->id)
            ->distinct('bank_id')
            ->count('bank_id');

        $totalAttempts = DB::table('evaluation_tests')
            ->where('student_id', $student->id)
            ->select('bank_id', DB::raw('MAX(trying) as attempts'))
            ->groupBy('bank_id')
            ->pluck('attempts')
            ->sum();

        return [
            'progress_this_month' => $progressThisMonth,
            'progress_trend' => $progressLastMonth > 0 ?
                round((($progressThisMonth - $progressLastMonth) / $progressLastMonth) * 100, 1) :
                ($progressThisMonth > 0 ? 100 : 0),
            'consultations_this_month' => $consultationsThisMonth,
            'events_this_month' => $eventsThisMonth,
            'total_tests' => $totalTests,
            'total_attempts' => $totalAttempts,
            'total_time_spent' => $student->studentPathProgress()->sum('time_spent'),
            'avg_attempts_per_point' => $student->studentPathProgress()->avg('attempt_count') ?? 0,
        ];
    }

    private function getAchievements(Student $student)
    {
        $achievements = collect();

        $eventCertificates = $student->studentPathProgress()
            ->where('status', 3)
            ->whereHas('pathPoint', function ($query) {
                $query->where('table_name', 'events');
            })
            ->with('pathPoint')
            ->get()
            ->map(function ($progress) {
                $eventId = $progress->pathPoint->meta['event_id'] ?? null;
                $eventType = null;
                $eventName = null;

                if ($eventId) {
                    $event = Event::find($eventId);
                    $eventType = $event ? $event->event_type : null;
                    $eventName = $event ? $event->event_name : null;
                }

                return (object) [
                    'type' => 'event',
                    'program_id' => $progress->program_id,
                    'path_point_id' => $progress->path_point_id,
                    'event_name' => $eventName,
                    'event_type' => $eventType,
                    'start_date' => $progress->completion_date,
                    'title' => $eventName,
                    'certificate_type' => $eventType === 'trip' ? 'Trip Certificate' : 'Workshop Certificate',
                    'download_route' => 'admin.student.trip.certificate',
                    'route_params' => ['program' => $progress->program_id, 'pathPoint' => $progress->path_point_id]
                ];
            });

        $programCertificates = $student->enrollments()
            ->with(['program'])
            ->where('status', 'attended')
            ->where('progress', '>=', 100)
            ->get()
            ->map(function ($enrollment) {
                return (object) [
                    'type' => 'program',
                    'program_id' => $enrollment->program_id,
                    'path_point_id' => null,
                    'event_name' => null,
                    'event_type' => 'program_completion',
                    'start_date' => $enrollment->updated_at,
                    'title' => app()->getLocale() == 'ar' ?
                        $enrollment->program->title_ar : $enrollment->program->title_en,
                    'certificate_type' => 'Program Completion Certificate',
                    'download_route' => 'admin.student.certificate.download',
                    'route_params' => ['programId' => $enrollment->program_id]
                ];
            });

        $volunteerCertificates = $student->volunteerHours()
            ->with(['event', 'program'])
            ->get()
            ->map(function ($volunteerHour) {
                return (object) [
                    'type' => 'volunteer',
                    'program_id' => $volunteerHour->program_id,
                    'event_id' => $volunteerHour->event_id,
                    'volunteer_hour_id' => $volunteerHour->id,
                    'event_name' => $volunteerHour->event->event_name,
                    'event_type' => $volunteerHour->event->event_type,
                    'volunteer_hours' => $volunteerHour->hours,
                    'student_id_number' => $volunteerHour->student_id_number,
                    'start_date' => $volunteerHour->volunteer_date,
                    'title' => $volunteerHour->event->event_name,
                    'certificate_type' => 'Community Service Certificate',
                    'download_route' => 'admin.student.volunteer.certificate',
                    'route_params' => ['volunteerHourId' => $volunteerHour->id]
                ];
            });

        $achievements = $eventCertificates->merge($programCertificates)->merge($volunteerCertificates)
            ->sortByDesc('start_date');

        return $achievements;
    }
}
