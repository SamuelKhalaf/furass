<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationNotes;
use App\Models\Student;
use App\Models\Consultant;
use App\Models\Program;
use App\Models\PathPoint;
use App\Models\StudentPathProgress;
use App\Models\Enrollment;
use App\Services\IStudentProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{

    /**
     * @var IStudentProgressService
     */
    protected IStudentProgressService $progressService;

    /**
     * @param IStudentProgressService $progressService
     */
    public function __construct(IStudentProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Display consultation details for a student
     */
    public function showStudentConsultation(Request $request, $programId, $pathPointId)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $program = Program::findOrFail($programId);
        $pathPoint = PathPoint::findOrFail($pathPointId);

        // Check if a student is enrolled in the program
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('program_id', $program->id)
            ->firstOrFail();

        // Get student progress for this path point
        $progress = StudentPathProgress::where('student_id', $student->id)
            ->where('program_id', $program->id)
            ->where('path_point_id', $pathPoint->id)
            ->firstOrFail();

        // Get consultation if exists
        $consultation = Consultation::where('student_id', $student->id)
            ->whereHas('consultant.assignedSchools', function($query) use ($student) {
                $query->where('school_id', $student->school_id);
            })
            ->where('updated_at', '>=', $progress->updated_at)
            ->latest()
            ->first();

        // Get consultation notes if consultation is completed
        $consultationNotes = null;
        if ($consultation && $consultation->status === 'done') {
            $consultationNotes = ConsultationNotes::where('consultation_id', $consultation->id)->first();
        }

        return view('admin.consultations.student.show_consultation', compact(
            'student', 'program', 'pathPoint', 'progress', 'consultation', 'consultationNotes'
        ));
    }

    /**
     * Display a list of students needing consultation for a consultant
     */
    public function consultantStudentsList()
    {
        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();

        // Get students from consultant's schools who need consultation
        $students = Student::whereIn('school_id', function ($query) use ($consultant) {
            $query->select('school_id')
                ->from('consultant_school')
                ->where('consultant_id', $consultant->id);
        })
            ->whereHas('studentPathProgress', function($query) {
                $query->whereHas('pathPoint', function($subQuery) {
                    $subQuery->where('table_name', 'consultations');
                })
                ->whereIn('status', [2, 3]);
            })
            ->with([
                'user',
                'school',
                'studentPathProgress' => function($query) {
                    $query->whereHas('pathPoint', function($subQuery) {
                        $subQuery->where('table_name', 'consultations');
                    })
                        ->whereIn('status', [2, 3])
                        ->with(['program', 'pathPoint']);
                }
            ])
            ->get();

        return view('admin.consultations.consultant.students_list', compact('students'));
    }

    /**
     * Show a consultation scheduling form for a consultant
     */
    public function showScheduleForm($studentId, $programId, $pathPointId)
    {
        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();
        $student = Student::findOrFail($studentId);
        $program = Program::findOrFail($programId);
        $pathPoint = PathPoint::findOrFail($pathPointId);

        // Verify a consultant has access to this student
        $hasAccess = DB::table('consultant_school')
            ->where('consultant_id', $consultant->id)
            ->where('school_id', $student->school_id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized access to student consultation');
        }

        // Get student progress
        $progress = StudentPathProgress::where('student_id', $student->id)
            ->where('program_id', $program->id)
            ->where('path_point_id', $pathPoint->id)
            ->firstOrFail();

        // Check if consultation already exists
        $existingConsultation = Consultation::where('student_id', $student->id)
            ->where('consultant_id', $consultant->id)
            ->where('updated_at', '>=', $progress->updated_at)
            ->first();

        return view('admin.consultations.consultant.schedule_consultation_form', compact(
            'student', 'program', 'pathPoint', 'progress', 'existingConsultation'
        ));
    }

    /**
     * Schedule consultation (create a Zoom meeting)
     */
    public function scheduleConsultation(Request $request, $studentId, $programId, $pathPointId)
    {
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'zoom_meeting_id' => 'required|string',
            'zoom_join_url' => 'required|url',
            'zoom_start_url' => 'required|url',
            'zoom_password' => 'nullable|string'
        ]);

        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();
        $student = Student::findOrFail($studentId);
        $program = Program::findOrFail($programId);
        $pathPoint = PathPoint::findOrFail($pathPointId);

        // Verify a consultant has access to this student
        $hasAccess = DB::table('consultant_school')
            ->where('consultant_id', $consultant->id)
            ->where('school_id', $student->school_id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized access to student consultation');
        }
        DB::transaction(function() use ($request, $studentId, $programId, $pathPointId, $consultant, $student, $program, $pathPoint) {
            // Create or update consultation
            $consultation = Consultation::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'consultant_id' => $consultant->id,
                ],
                [
                    'scheduled_at' => $request->scheduled_at,
                    'status' => 'pending',
                    'zoom_meeting_id' => $request->zoom_meeting_id,
                    'zoom_join_url' => $request->zoom_join_url,
                    'zoom_start_url' => $request->zoom_start_url,
                    'zoom_password' => $request->zoom_password,
                ]
            );

            // Load the consultant relationship for the consultation
            $consultation->load('consultant.user');

            // Send an email notification to a student
            try {
                Mail::to($student->user->email)->queue(new \App\Mail\ConsultationScheduled($consultation, $student, $program, $pathPoint));
            } catch (\Exception $e) {
                Log::error('Failed to send consultation email: ' . $e->getMessage());
            }
        });

        return redirect()->route('admin.consultant.students.index')
            ->with('success', __('Consultation scheduled successfully'));
    }

    /**
     * Join a consultation meeting for a student
     */
    public function joinConsultation($consultationId)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::where('id', $consultationId)
            ->where('student_id', $student->id)
            ->where('status', 'pending')
            ->firstOrFail();

        // Check if consultation time is within 15 minutes
        $scheduledTime = Carbon::parse($consultation->scheduled_at);
        $now = Carbon::now();

        if ($now->diffInMinutes($scheduledTime, false) > 15) {
            return redirect()->back()->with('error', __('Consultation has not started yet'));
        }

        if ($now->diffInMinutes($scheduledTime) > 60) {
            return redirect()->back()->with('error', __('Consultation time has passed'));
        }

        return redirect($consultation->zoom_join_url);
    }

    /**
     * Start a consultation meeting for a consultant
     */
    public function startConsultation($consultationId)
    {
        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::where('id', $consultationId)
            ->where('consultant_id', $consultant->id)
            ->where('status', 'pending')
            ->firstOrFail();

        return redirect($consultation->zoom_start_url);
    }

    /**
     * Show consultation notes form for a consultant
     */
    public function showNotesForm($consultationId)
    {
        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::with(['student.user', 'student.school'])
            ->where('id', $consultationId)
            ->where('consultant_id', $consultant->id)
            ->firstOrFail();

        $existingNotes = ConsultationNotes::where('consultation_id', $consultation->id)->first();

        return view('admin.consultations.consultant.consultation_notes', compact('consultation', 'existingNotes'));
    }

    /**
     * Save consultation notes and mark consultation as done
     */
    public function saveNotes(Request $request, $consultationId)
    {
        $request->validate([
            'notes' => 'required|string|min:10',
            'report_pdf' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::with(['student.user', 'consultant.user'])
            ->where('id', $consultationId)
            ->where('consultant_id', $consultant->id)
            ->firstOrFail();

        DB::transaction(function() use ($request, $consultation) {
            $data = ['notes' => $request->notes];
            $existingNotes = ConsultationNotes::where('consultation_id', $consultation->id)->first();

            // Handle PDF upload
            if ($request->hasFile('report_pdf')) {
                // Delete an old file if exists
                if ($existingNotes && $existingNotes->report_pdf) {
                    Storage::disk('public')->delete($existingNotes->report_pdf);
                }

                // Store a new file with sanitized name
                $extension = $request->file('report_pdf')->getClientOriginalExtension();
                $fileName = 'Consultation_Report_' . time() . '.' . $extension;
                $path = $request->file('report_pdf')->storeAs('consultation_reports', $fileName, 'public');
                $data['report_pdf'] = $path;
            }

            // Save consultation notes
            $consultationNotes = ConsultationNotes::updateOrCreate(
                ['consultation_id' => $consultation->id],
                $data
            );

            // Mark consultation as done
            $consultation->update(['status' => 'done']);

            // Update student path progress to complete
            $progress = StudentPathProgress::where('student_id', $consultation->student_id)
                ->whereHas('pathPoint', function($query) {
                    $query->where('table_name', 'consultations');
                })
                ->where('status', 2)
                ->first();

            if ($progress) {
                $progress->update([
                    'status' => 3, // Completed
                    'completion_date' => now(),
                    'updated_at' => now()
                ]);

                // Get the program and path point for the email
                $program = Program::find($progress->program_id);
                $pathPoint = PathPoint::find($progress->path_point_id);

                // Send completion email to a student
                try {
                    Mail::to($consultation->student->user->email)->queue(
                        new \App\Mail\ConsultationCompleted(
                            $consultation,
                            $consultationNotes,
                            $consultation->student,
                            $program,
                            $pathPoint
                        )
                    );
                } catch (\Exception $e) {
                    Log::error('Failed to send consultation completion email: ' . $e->getMessage());
                }

                // Update overall program progress
                $this->progressService->updateProgramProgress($consultation->student_id, $progress->program_id);

                // Unlock next path point
                $this->progressService->unlockNextPathPoint($consultation->student_id, $progress->program_id, $progress->path_point_id);
            }
        });

        return redirect()->route('admin.consultant.students.index')
            ->with('success', __('Consultation notes saved successfully'));
    }

    /**
     * View consultation notes for student
     */
    public function viewNotes($consultationId)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::with(['consultant.user'])
            ->where('id', $consultationId)
            ->where('student_id', $student->id)
            ->where('status', 'done')
            ->firstOrFail();

        $notes = ConsultationNotes::where('consultation_id', $consultation->id)->firstOrFail();

        return view('admin.consultations.student.show_consultation_notes', compact('consultation', 'notes'));
    }

    /**
     * Cancel consultation
     */
    public function cancelConsultation($consultationId)
    {
        $consultant = Consultant::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::where('id', $consultationId)
            ->where('consultant_id', $consultant->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $consultation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', __('Consultation cancelled successfully'));
    }

    /**
     * Cancel consultation by student
     */
    public function cancelByStudent($consultationId)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::where('id', $consultationId)
            ->where('student_id', $student->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $consultation->update(['status' => 'cancelled_by_student']);

        return redirect()->back()->with('success', __('Consultation cancelled successfully. Please wait for a new schedule.'));
    }
}
