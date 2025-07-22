<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'consultant_school');
    }

    public function assignedSchools()
    {
        return $this->belongsToMany(\App\Models\School::class, 'consultant_school', 'consultant_id', 'school_id');
    }

    public function tripAttendanceRecords()
    {
        return $this->hasMany(TripAttendance::class, 'recorded_by');
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            Consultation::class,
            'consultant_id',
            'id',
            'id',
            'student_id'
        );
    }
}
