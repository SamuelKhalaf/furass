<?php

namespace App\Mail;

use App\Models\Consultation;
use App\Models\Student;
use App\Models\Program;
use App\Models\PathPoint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ConsultationScheduled extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $consultation;
    public $student;
    public $program;
    public $pathPoint;

    public function __construct(Consultation $consultation, Student $student, Program $program, PathPoint $pathPoint)
    {
        $this->consultation = $consultation;
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
            subject: 'Consultation Scheduled - ' . ($this->program->title_en ?? $this->program->title_ar),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $scheduledDate = Carbon::parse($this->consultation->scheduled_at);

        return new Content(
            view: 'emails.consultation_scheduled',
            with: [
                'studentName'      => $this->student->user->name,
                'consultantName'   => $this->consultation->consultant->user->name,
                'programTitle'     => $this->program->title_en ?? $this->program->title_ar,
                'pathPointTitle'   => $this->pathPoint->title_en ?? $this->pathPoint->title_ar,
                'scheduledDate'    => $scheduledDate->format('l, F j, Y'),
                'scheduledTime'    => $scheduledDate->format('g:i A'),
                'joinUrl'          => $this->consultation->zoom_join_url,
                'meetingPassword'  => $this->consultation->zoom_password,
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
        return [];
    }
}
