<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'event_id',
        'status',
        'notes',
        'recorded_by',
        'recorded_at'
    ];

    protected $casts = [
        'recorded_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(Consultant::class, 'recorded_by');
    }}
