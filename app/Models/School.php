<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'logo',
        'max_students',
        'is_opened'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function consultants()
    {
        return $this->belongsToMany(Consultant::class, 'consultant_school');
    }

    /**
     * Get the users associated with the school (sub-admins)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'sub_admin_school', 'school_id', 'sub_admin_id');
    }

    /**
     * Get the current number of students in this school
     */
    public function getCurrentStudentsCount()
    {
        return $this->student()->count();
    }

    /**
     * Check if the school has reached its maximum student limit
     */
    public function hasReachedMaxStudents()
    {
        if (is_null($this->max_students)) {
            return false; // No limit set
        }
        
        return $this->getCurrentStudentsCount() >= $this->max_students;
    }

    /**
     * Check if adding one more student would exceed the limit
     */
    public function wouldExceedMaxStudents()
    {
        if (is_null($this->max_students)) {
            return false; // No limit set
        }
        
        return $this->getCurrentStudentsCount() >= $this->max_students;
    }
}
