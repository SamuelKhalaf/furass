<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_id_number',
        'event_id',
        'program_id',
        'hours',
        'volunteer_date',
        'description',
        'recorded_by'
    ];

    protected $casts = [
        'volunteer_date' => 'date',
        'hours' => 'decimal:2'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
