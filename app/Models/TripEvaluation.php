<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'event_id',
        'rating',
        'feedback',
        'learning_outcomes',
        'suggestions'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
