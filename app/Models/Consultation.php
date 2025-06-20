<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'consultant_id',
        'scheduled_at',
        'status',
        'zoom_meeting_id',
        'zoom_join_url',
        'zoom_start_url',
        'zoom_password',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function notes()
    {
        return $this->hasMany(ConsultationNotes::class);
    }
}
