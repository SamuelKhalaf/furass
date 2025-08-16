<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    const RELATIONSHIP_FATHER = 1;
    const RELATIONSHIP_MOTHER = 2;
    const RELATIONSHIP_SIBLING = 3;
    const RELATIONSHIP_OTHER = 4;

    protected $fillable = [
        'user_id',
        'school_id',
        'student_id_number',
        'grade',
        'birth_date',
        'gender',
        'avatar',
        'parent_name',
        'parent_phone',
        'parent_relationship'
    ];

    public static function relationshipOptions()
    {
        return [
            self::RELATIONSHIP_FATHER => __('students.modal.father'),
            self::RELATIONSHIP_MOTHER => __('students.modal.mother'),
            self::RELATIONSHIP_SIBLING => __('students.modal.sibling'),
            self::RELATIONSHIP_OTHER => __('students.modal.other'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function evaluationTests()
    {
        return $this->hasMany(\App\Models\EvaluationTest::class, 'student_id');
    }

    public function studentPathProgress()
    {
        return $this->hasMany(StudentPathProgress::class);
    }

    public function tripAttendances()
    {
        return $this->hasMany(TripAttendance::class);
    }

    public function tripEvaluations()
    {
        return $this->hasMany(TripEvaluation::class);
    }

    public function consultations()
    {
        return $this->hasMany(\App\Models\Consultation::class, 'student_id', 'id');
    }

    public function volunteerHours()
    {
        return $this->hasMany(VolunteerHour::class);
    }
}
