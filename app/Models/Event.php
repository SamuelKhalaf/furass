<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'company_name',
        'location',
        'start_date',
        'end_date',
        'description',
        'media_path',
        'document_path',
        'event_type'
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'event_program');
    }

    public function tripAttendances()
    {
        return $this->hasMany(TripAttendance::class);
    }

    public function tripEvaluations()
    {
        return $this->hasMany(TripEvaluation::class);
    }
}
