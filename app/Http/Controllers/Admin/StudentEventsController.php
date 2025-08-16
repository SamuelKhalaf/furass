<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Event;
use App\Models\PathPoint;
use App\Models\Program;
use App\Models\Student;
use App\Models\StudentPathProgress;
use App\Models\TripAttendance;
use App\Models\TripEvaluation;
use App\Models\VolunteerHour;
use App\Services\IStudentProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class StudentEventsController extends Controller
{
    protected IStudentProgressService $progressService;

    public function __construct(IStudentProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Show all trips for the sub-admin with enrolled students
     */
    public function subAdminTrips()
    {
        $trips = $this->getSubAdminEvents('trip');
        return view('admin.trips.sub_admin_trips_index', ['trips' => $trips]);
    }

    /**
     * Show all workshops for the sub-admin with enrolled students
     */
    public function subAdminWorkshops()
    {
        $workshops = $this->getSubAdminEvents('workshop');
        return view('admin.workshops.sub_admin_workshop_index', ['workshops' => $workshops]);
    }

    /**
     * Helper method to get events by type for the sub-admin
     */
    private function getSubAdminEvents($eventType)
    {
        // Get sub-admin's associated schools from sub_admin_school table
        $subAdminSchools = DB::table('sub_admin_school')
            ->where('sub_admin_id', Auth::id())
            ->pluck('school_id');

        // Get all events (path points with table_name = 'events') that have enrolled students
        // and filter by event type
        $events = PathPoint::where('table_name', 'events')
            ->whereHas('programs.enrollments', function ($query) use ($subAdminSchools) {
                $query->where('status', 'active')
                    ->whereHas('student.school', function ($schoolQuery) use ($subAdminSchools) {
                        $schoolQuery->whereIn('id', $subAdminSchools);
                    });
            })
            ->where(function ($pathQuery) use ($subAdminSchools) {
                // Only include path points where at least one student has active status
                // for this specific path point
                $pathQuery->whereHas('studentPathProgress', function ($progressQuery) use ($subAdminSchools) {
                    $progressQuery->whereIn('status', [2,3,4])
                        ->whereHas('student.school', function ($schoolQuery) use ($subAdminSchools) {
                            $schoolQuery->whereIn('id', $subAdminSchools);
                        })
                        ->whereHas('student.enrollments', function ($enrollmentQuery) {
                            $enrollmentQuery->where('status', 'active');
                        });
                });
            })
            ->with([
                'programs' => function ($query) use ($subAdminSchools) {
                    $query->whereHas('enrollments', function ($enrollmentQuery) use ($subAdminSchools) {
                        $enrollmentQuery->where('status', 'active')
                            ->whereHas('student.school', function ($schoolQuery) use ($subAdminSchools) {
                                $schoolQuery->whereIn('id', $subAdminSchools);
                            })
                            ->whereHas('student.studentPathProgress', function ($progressQuery) {
                                $progressQuery->whereIn('status', [2,3,4]);
                            });
                    });
                }
            ])
            ->get();

        // Process each event to get event details and student counts
        // Filter by event type during processing
        $processedEvents = $events->map(function ($event) use ($subAdminSchools, $eventType) {
            $eventId = $event->meta['event_id'] ?? null;
            $eventRecord = $eventId ? Event::find($eventId) : null;

            if (!$eventRecord) {
                return null; // Skip events without valid event records
            }

            // Filter by event type
            if ($eventRecord->event_type !== $eventType) {
                return null; // Skip events that don't match the requested type
            }

            $event->event = $eventRecord;

            $programsData = [];
            foreach ($event->programs as $program) {
                $enrolledStudents = Student::whereHas('enrollments', function ($query) use ($program) {
                    $query->where('program_id', $program->id)
                        ->where('status', 'active');
                })
                    ->whereHas('school', function ($query) use ($subAdminSchools) {
                        $query->whereIn('id', $subAdminSchools);
                    })
                    ->whereHas('studentPathProgress', function ($query) use ($program, $event) {
                        $query->where('program_id', $program->id)
                            ->where('path_point_id', $event->id)
                            ->whereIn('status', [2,3,4]);
                    })
                    ->with(['tripAttendances' => function ($query) use ($eventId) {
                        $query->where('event_id', $eventId);
                    }])
                    ->get();

                $attendedCount = $enrolledStudents->filter(function ($student) {
                    return $student->tripAttendances->where('status', 'attended')->count() > 0;
                })->count();

                $absentCount = $enrolledStudents->filter(function ($student) {
                    return $student->tripAttendances->where('status', 'absent')->count() > 0;
                })->count();

                $pendingCount = $enrolledStudents->count() - $attendedCount - $absentCount;

                $programsData[] = [
                    'program' => $program,
                    'total_students' => $enrolledStudents->count(),
                    'attended_count' => $attendedCount,
                    'absent_count' => $absentCount,
                    'pending_count' => $pendingCount
                ];
            }

            $event->setAttribute('programs_data', $programsData);

            return $event;
        })->filter(); // Remove null values

        return $processedEvents;
    }

    public function showTripDetails(Program $program, PathPoint $pathPoint)
    {
        return $this->showEventDetails($program, $pathPoint, 'trip');
    }

    public function showWorkshopDetails(Program $program, PathPoint $pathPoint)
    {
        return $this->showEventDetails($program, $pathPoint, 'workshop');
    }

    private function showEventDetails(Program $program, PathPoint $pathPoint, $eventType)
    {
        $student = Student::where('user_id', Auth::id())->first();

        // Get student's progress for this path point
        $progress = StudentPathProgress::where('student_id', $student->id)
            ->where('program_id', $program->id)
            ->where('path_point_id', $pathPoint->id)
            ->first();

        if (!$progress) {
            abort(404, 'Progress not found');
        }

        // Get the event details from meta data
        $eventId = $pathPoint->meta['event_id'] ?? null;
        $event = $eventId ? Event::find($eventId) : null;

        if (!$event) {
            abort(404, ucfirst($eventType) . ' event not found');
        }

        // Verify event type matches
        if ($event->event_type !== $eventType) {
            abort(404, 'Event type mismatch');
        }

        // Check if a student has already evaluated
        $hasEvaluated = TripEvaluation::where('student_id', $student->id)
            ->where('event_id', $event->id)
            ->exists();

        // Get attendance status
        $attendance = TripAttendance::where('student_id', $student->id)
            ->where('event_id', $event->id)
            ->first();

        $viewName = $eventType === 'trip'
            ? 'admin.trips.show_student_trip_details'
            : 'admin.workshops.show_student_workshop_details';

        return view($viewName, compact(
            'program',
            'pathPoint',
            'progress',
            'event',
            'hasEvaluated',
            'attendance'
        ));
    }

    public function submitEvaluation(Request $request, Program $program, PathPoint $pathPoint)
    {
        $student = Student::where('user_id', Auth::id())->first();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|max:1000',
            'learning_outcomes' => 'required|string|max:1000',
            'suggestions' => 'nullable|string|max:1000'
        ]);

        $eventId = $pathPoint->meta['event_id'] ?? null;
        $event = Event::find($eventId);

        if (!$event) {
            return back()->with('error', 'Event not found');
        }

        // Check if already evaluated
        $existingEvaluation = TripEvaluation::where('student_id', $student->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existingEvaluation) {
            return back()->with('error', 'You have already evaluated this ' . $event->event_type);
        }

        TripEvaluation::create([
            'student_id' => $student->id,
            'event_id' => $event->id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'learning_outcomes' => $request->learning_outcomes,
            'suggestions' => $request->suggestions
        ]);

        return back()->with('success', 'Thank you for your evaluation!');
    }

    public function downloadCertificate(Program $program, PathPoint $pathPoint)
    {
        $student = Student::where('user_id', Auth::id())->first();

        // Check if a student attended the trip
        $eventId = $pathPoint->meta['event_id'] ?? null;
        $attendance = TripAttendance::where('student_id', $student->id)
            ->where('event_id', $eventId)
            ->where('status', 'attended')
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Certificate not available. You must attend the trip first.');
        }

        // Check if a student has evaluated
        $hasEvaluated = TripEvaluation::where('student_id', $student->id)
            ->where('event_id', $eventId)
            ->exists();

        if (!$hasEvaluated) {
            return back()->with('error', 'Please complete the trip evaluation first to download your certificate.');
        }

        $event = Event::find($eventId);

        $pdf = PDF::loadView('admin.certificates.certificate', [
            'student' => $student,
            'event' => $event,
            'program' => $program,
            'attendance' => $attendance
        ]);

        return $pdf->stream('event_certificate_' . time() . '.pdf');
    }

    public function attendance(Program $program, PathPoint $pathPoint)
    {
        // Check if a user is a sub-admin with access to schools
        $subAdminSchools = DB::table('sub_admin_school')
            ->where('sub_admin_id', Auth::id())
            ->pluck('school_id');

        // Get the event details from meta data
        $eventId = $pathPoint->meta['event_id'] ?? null;
        $event = $eventId ? Event::find($eventId) : null;

        if (!$event) {
            abort(404, 'Event not found');
        }

        // Get all students enrolled in this program from sub-admin's schools
        $students = Student::whereHas('enrollments', function ($query) use ($program) {
            $query->where('program_id', $program->id)
                ->where('status', 'active');
        })
            ->whereHas('studentPathProgress', function ($query) use ($program, $pathPoint) {
                $query->where('program_id', $program->id)
                    ->where('path_point_id', $pathPoint->id)
                    ->whereIn('status', [2,3,4]);
            })
            ->whereHas('school', function ($query) use ($subAdminSchools) {
                $query->whereIn('id', $subAdminSchools);
            })
            ->with(['user', 'school.user'])
            ->get();

        // Get attendance records for this event
        $attendanceRecords = TripAttendance::where('event_id', $event->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        // Determine the view based on event type
        $viewName = $event->event_type === 'trip'
            ? 'admin.trips.sub_admin_trip_attendance'
            : 'admin.workshops.sub_admin_workshop_attendance';

        return view($viewName, compact(
            'program',
            'pathPoint',
            'event',
            'students',
            'attendanceRecords'
        ));
    }

    public function updateAttendance(Request $request, Program $program, PathPoint $pathPoint)
    {
        // Check if a user is a sub-admin with access to schools
        $subAdminSchools = DB::table('sub_admin_school')
            ->where('sub_admin_id', Auth::id())
            ->pluck('school_id');

        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:attended,absent',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        $eventId = $pathPoint->meta['event_id'] ?? null;
        $event = Event::find($eventId);

        if (!$event) {
            return back()->with('error', 'Event not found');
        }

        DB::beginTransaction();

        try {
            foreach ($request->attendance as $studentId => $status) {
                // Verify that the student belongs to one of the sub-admin's schools
                $studentBelongsToSubAdmin = Student::where('id', $studentId)
                    ->whereHas('school', function ($query) use ($subAdminSchools) {
                        $query->whereIn('id', $subAdminSchools);
                    })
                    ->exists();

                if (!$studentBelongsToSubAdmin) {
                    continue; // Skip students not belonging to sub-admin's schools
                }

                TripAttendance::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'event_id' => $event->id
                    ],
                    [
                        'status' => $status,
                        'notes' => $request->notes[$studentId] ?? null,
                        'recorded_by' => Auth::id(),
                        'recorded_at' => now()
                    ]
                );

                // Update student progress based on attendance
                $newStatus = $status === 'attended' ? 3 : 4; // 3 = completed, 4 = skipped

                $updateData = [
                    'status' => $newStatus,
                ];

                // Only set completion_date if completed
                if ($newStatus === 3) {
                    $updateData['completion_date'] = now();
                }

                $updated = StudentPathProgress::where('student_id', $studentId)
                    ->where('program_id', $program->id)
                    ->where('path_point_id', $pathPoint->id)
                    ->whereIn('status', [2,3,4])
                    ->update($updateData);

                if ($updated) {
                    $this->progressService->unlockNextPathPoint($studentId,$program->id,$pathPoint->id);
                    $this->progressService->updateProgramProgress($studentId,$program->id);
                }
            }

            DB::commit();

            $eventType = $event->event_type === 'trip' ? 'trip' : 'workshop';
            return back()->with('success', ucfirst($eventType) . ' attendance updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating attendance: ' . $e->getMessage());
        }
    }

    public function studentsList(Program $program, PathPoint $pathPoint)
    {
        // Check if user is a sub-admin with access to schools
        $subAdminSchools = DB::table('sub_admin_school')
            ->where('sub_admin_id', Auth::id())
            ->pluck('school_id');

        if ($subAdminSchools->isEmpty()) {
            abort(403, 'You are not authorized');
        }

        $eventId = $pathPoint->meta['event_id'] ?? null;
        $event = Event::find($eventId);

        if (!$event) {
            abort(404, 'Event not found');
        }

        // Get students with their attendance and evaluation status from sub-admin's schools
        $students = Student::whereHas('enrollments', function ($query) use ($program) {
            $query->where('program_id', $program->id)
                ->where('status', 'active');
        })
            ->whereHas('studentPathProgress', function ($query) use ($program, $pathPoint) {
                $query->where('program_id', $program->id)
                    ->where('path_point_id', $pathPoint->id)
                    ->whereIn('status', [2,3,4]);
            })
            ->whereHas('school', function ($query) use ($subAdminSchools) {
                $query->whereIn('id', $subAdminSchools);
            })
            ->with([
                'user',
                'school.user',
                'tripAttendances' => function ($query) use ($eventId) {
                    $query->where('event_id', $eventId);
                },
                'tripEvaluations' => function ($query) use ($eventId) {
                    $query->where('event_id', $eventId);
                }
            ])
            ->get();

        // Determine the view based on event type
        $viewName = $event->event_type === 'trip'
            ? 'admin.trips.sub_admin_list_trip_students'
            : 'admin.workshops.sub_admin_list_workshop_students';

        return view($viewName, compact(
            'program',
            'pathPoint',
            'event',
            'students'
        ));
    }

    public function addVolunteerHours(Program $program, PathPoint $pathPoint)
    {
        $subAdminSchools = DB::table('sub_admin_school')
            ->where('sub_admin_id', Auth::id())
            ->pluck('school_id');

        if ($subAdminSchools->isEmpty()) {
            abort(403, 'You are not authorized');
        }

        $eventId = $pathPoint->meta['event_id'] ?? null;
        $event = Event::find($eventId);

        if (!$event) {
            abort(404, 'Event not found');
        }

        // Get students with attendance marked as 'attended' from sub-admin's schools
        $students = Student::whereHas('enrollments', function ($query) use ($program) {
            $query->where('program_id', $program->id)
                ->where('status', 'active');
        })
            ->whereHas('studentPathProgress', function ($query) use ($program, $pathPoint) {
                $query->where('program_id', $program->id)
                    ->where('path_point_id', $pathPoint->id)
                    ->whereIn('status', [2,3,4]);
            })
            ->whereHas('school', function ($query) use ($subAdminSchools) {
                $query->whereIn('id', $subAdminSchools);
            })
            ->whereHas('tripAttendances', function ($query) use ($eventId) {
                $query->where('event_id', $eventId)->where('status', 'attended');
            })
            ->with(['user', 'school.user', 'volunteerHours' => function ($query) use ($eventId, $program) {
                $query->where('event_id', $eventId)->where('program_id', $program->id);
            }])
            ->get();

        // Determine the view based on event type
        $viewName = $event->event_type === 'trip'
            ? 'admin.trips.add_volunteer_hours'
            : 'admin.workshops.add_volunteer_hours';

        return view($viewName, compact(
            'program',
            'pathPoint',
            'event',
            'students'
        ));
    }

    public function storeVolunteerHours(Request $request, Program $program, PathPoint $pathPoint)
    {
        $subAdminSchools = DB::table('sub_admin_school')
            ->where('sub_admin_id', Auth::id())
            ->pluck('school_id');

        if ($subAdminSchools->isEmpty()) {
            abort(403, 'You are not authorized');
        }

        $request->validate([
            'volunteer_hours' => 'required|array',
            'volunteer_hours.*.student_id' => 'required|exists:students,id',
//            'volunteer_hours.*.student_id_number' => 'required|string|max:50',
            'volunteer_hours.*.hours' => 'required|numeric|min:0.1|max:100',
            'volunteer_hours.*.volunteer_date' => 'required|date',
            'volunteer_hours.*.description' => 'nullable|string|max:500'
        ]);

        $eventId = $pathPoint->meta['event_id'] ?? null;
        $event = Event::find($eventId);

        if (!$event) {
            return back()->with('error', 'Event not found');
        }

        DB::beginTransaction();

        try {
            foreach ($request->volunteer_hours as $volunteerData) {
                // Verify that the student belongs to one of the sub-admin's schools
                $studentBelongsToSubAdmin = Student::where('id', $volunteerData['student_id'])
                    ->whereHas('school', function ($query) use ($subAdminSchools) {
                        $query->whereIn('id', $subAdminSchools);
                    })
                    ->exists();

                if (!$studentBelongsToSubAdmin) {
                    continue; // Skip students not belonging to sub-admin's schools
                }

                // Check if volunteer hours already exist for this student, event, and program
                $existingRecord = VolunteerHour::where('student_id', $volunteerData['student_id'])
                    ->where('event_id', $event->id)
                    ->where('program_id', $program->id)
                    ->first();

                if ($existingRecord) {
                    // Update existing record
                    $existingRecord->update([
//                        'student_id_number' => $volunteerData['student_id_number'],
                        'hours' => $volunteerData['hours'],
                        'volunteer_date' => $volunteerData['volunteer_date'],
                        'description' => $volunteerData['description'] ?? null,
                        'recorded_by' => Auth::id()
                    ]);
                } else {
                    // Create new record
                    VolunteerHour::create([
                        'student_id' => $volunteerData['student_id'],
//                        'student_id_number' => $volunteerData['student_id_number'],
                        'event_id' => $event->id,
                        'program_id' => $program->id,
                        'hours' => $volunteerData['hours'],
                        'volunteer_date' => $volunteerData['volunteer_date'],
                        'description' => $volunteerData['description'] ?? null,
                        'recorded_by' => Auth::id()
                    ]);
                }
            }

            DB::commit();

            $eventType = $event->event_type === 'trip' ? 'trip' : 'workshop';
            return back()->with('success', 'Volunteer hours for ' . $eventType . ' have been saved successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error saving volunteer hours');
        }
    }

    public function downloadVolunteerCertificate($volunteerHourId)
    {
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            abort(404, 'Student not found');
        }

        // Get the volunteer hour record with relationships
        $volunteerHour = VolunteerHour::with(['student.user', 'event', 'program'])
            ->where('id', $volunteerHourId)
            ->where('student_id', $student->id)
            ->first();

        if (!$volunteerHour) {
            abort(404, 'Volunteer hours record not found or you do not have access to this certificate.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.certificates.volunteer_hours', [
            'volunteerHour' => $volunteerHour,
            'student' => $student
        ]);

        return $pdf->stream('volunteer_certificate_' . $volunteerHour->event->event_name . '.pdf');
    }
}
