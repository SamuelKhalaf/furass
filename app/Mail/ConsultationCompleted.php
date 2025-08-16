<?php

namespace App\Mail;

use App\Models\Consultation;
use App\Models\ConsultationNotes;
use App\Models\Student;
use App\Models\Program;
use App\Models\PathPoint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ConsultationCompleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $consultation;
    public $consultationNotes;
    public $student;
    public $program;
    public $pathPoint;

    public function __construct(
        Consultation $consultation,
        ConsultationNotes $consultationNotes,
        Student $student,
        Program $program,
        PathPoint $pathPoint
    ) {
        $this->consultation = $consultation;
        $this->consultationNotes = $consultationNotes;
        $this->student = $student;
        $this->program = $program;
        $this->pathPoint = $pathPoint;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consultation Completed - ' . ($this->program->title_en ?? $this->program->title_ar),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $scheduledDate = Carbon::parse($this->consultation->scheduled_at);
        $completedDate = Carbon::parse($this->consultation->updated_at);

        return new Content(
            view: 'emails.consultation_completed',
            with: [
                'studentName'      => $this->student->user->name,
                'consultantName'   => $this->consultation->consultant->user->name,
                'programTitle'     => $this->program->title_en ?? $this->program->title_ar,
                'pathPointTitle'   => $this->pathPoint->title_en ?? $this->pathPoint->title_ar,
                'scheduledDate'    => $scheduledDate->format('l, F j, Y'),
                'scheduledTime'    => $scheduledDate->format('g:i A'),
                'completedDate'    => $completedDate->format('l, F j, Y'),
                'completedTime'    => $completedDate->format('g:i A'),
                'consultationNotes' => $this->consultationNotes->notes,
                'hasReportPdf'     => !empty($this->consultationNotes->report_pdf),
                'viewNotesUrl'     => route('admin.student.consultation.notes', $this->consultation->id),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach a PDF report if exists
        if (!empty($this->consultationNotes->report_pdf) && Storage::disk('public')->exists($this->consultationNotes->report_pdf)) {
            $attachments[] = Attachment::fromStorageDisk('public', $this->consultationNotes->report_pdf)
                ->as('Consultation_Report_' . $this->student->user->name . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
