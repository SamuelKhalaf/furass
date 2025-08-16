<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index');
    }

    /**
     * Get all calendar events for FullCalendar
     */
    public function getCalendarData(): JsonResponse
    {
        try {
            $events = Event::with('programs')->get();

            $formattedEvents = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'event_name' => $event->event_name,
                    'company_name' => $event->company_name,
                    'location' => $event->location,
                    'description' => $event->description,
                    'event_type' => $event->event_type,
                    'media_path' => $event->media_path,
                    'document_path' => $event->document_path,
                    'start_date' => Carbon::parse($event->start_date)->toISOString(),
                    'end_date' => Carbon::parse($event->end_date)->toISOString(),
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at
                ];
            });
            return response()->json($formattedEvents);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch events'], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
//            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'event_type' => 'required|in:trip,workshop',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:programs,id'
        ]);

        try {
            $event = Event::create($validated);

            // Attach programs if provided
            if (isset($validated['program_ids'])) {
                $event->programs()->attach($validated['program_ids']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'event' => $event->load('programs')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create event'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
//            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'event_type' => 'required|in:trip,workshop',
            'program_ids' => 'nulllable|array',
            'program_ids.*' => 'exists:programs,id'
        ]);

        try {
            $event->update($validated);

            // Sync programs
            if (isset($validated['program_ids'])) {
                $event->programs()->sync($validated['program_ids']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully',
                'event' => $event->load('programs')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update event'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            // Delete associated files
            if ($event->media_path && Storage::exists(str_replace('storage/', 'public/', $event->media_path))) {
                Storage::delete(str_replace('storage/', 'public/', $event->media_path));
            }

            if ($event->document_path && Storage::exists(str_replace('storage/', 'public/', $event->document_path))) {
                Storage::delete(str_replace('storage/', 'public/', $event->document_path));
            }

            // Delete the trip
            $event->programs()->detach();
            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete event'
            ], 500);
        }
    }

    /**
     * Get CSS class name based on event type
     */
    private function getEventClassName($eventType)
    {
        switch ($eventType) {
            case 'trip':
                return 'fc-event-light fc-event-solid-primary';
            case 'workshop':
                return 'fc-event-danger fc-event-solid-warning';
            default:
                return 'fc-event-info';
        }
    }
}
