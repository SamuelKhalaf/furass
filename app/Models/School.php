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
        'logo'
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
}
