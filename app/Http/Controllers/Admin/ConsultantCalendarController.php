<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultantCalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.consultant_calendar');
    }

    public function getEvents(Request $request)
    {
        $consultantId = Consultant::where('user_id', Auth::id())->first()->id;
        $events = [];

        // Get consultations for this consultant
        $consultations = Consultation::where('consultant_id', $consultantId)
            ->where('status', 'pending')
            ->with('student.user') // Eager load student relationship
            ->get();

        foreach ($consultations as $consultation) {
            $events[] = [
                'title' => 'Consultation with ' . $consultation->student->user->name,
                'start' => $consultation->scheduled_at,
                'end' => Carbon::parse($consultation->scheduled_at)->addHour(),
                'backgroundColor' => '#3699FF',
                'borderColor' => '#3699FF',
                'textColor' => '#181C32',
                'extendedProps' => [
                    'type' => 'consultation',
                    'description' => 'Scheduled consultation session',
                    'status' => $consultation->status,
                    'student_id' => $consultation->student_id,
                    'student_name' => $consultation->student->user->name,
                ]
            ];
        }

        return response()->json($events);
    }
}
