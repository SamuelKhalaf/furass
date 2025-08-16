<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Event;
use App\Models\Student;
use App\Models\StudentPathProgress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.student_calendar');
    }

    public function getEvents(Request $request)
    {
        $studentId = Student::where('user_id', Auth::id())->first()->id;
        $events = [];

        // Get consultations
        $consultations = Consultation::where('student_id', $studentId)
            ->where('status', 'pending')
            ->get();

        foreach ($consultations as $consultation) {
            $events[] = [
                'title' => 'Consultation with Advisor',
                'start' => $consultation->scheduled_at,
                'end' => Carbon::parse($consultation->scheduled_at)->addHour(),
                'backgroundColor' => '#3699FF',
                'borderColor' => '#3699FF',
                'textColor' => '#181C32',
                'extendedProps' => [
                    'type' => 'consultation',
                    'description' => 'Scheduled consultation session with your advisor',
                    'status' => $consultation->status,
                    'consultant_id' => $consultation->consultant_id,
                ]
            ];
        }

        // Get events (trips and workshops)
        $progressItems = StudentPathProgress::where('student_id', $studentId)
            ->whereIn('status', [2]) // active or completed
            ->with('pathPoint')
            ->get();

        foreach ($progressItems as $progress) {
            if ($progress->pathPoint->table_name === 'events') {
                $event = Event::find($progress->pathPoint->meta['event_id'] ?? null);
                if ($event) {
                    $events[] = [
                        'title' => $event->event_name,
                        'start' => $event->start_date,
                        'end' => $event->end_date,
                        'backgroundColor' => $event->event_type === 'trip' ? '#F64E60' : '#FFA800',
                        'borderColor' => $event->event_type === 'trip' ? '#F64E60' : '#FFA800',
                        'textColor' => '#181C32',
                        'extendedProps' => [
                            'type' => $event->event_type,
                            'description' => $event->description,
                            'location' => $event->location,
                        ]
                    ];
                }
            }
        }

        return response()->json($events);
    }}
