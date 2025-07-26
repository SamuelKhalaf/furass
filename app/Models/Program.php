<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_program');
    }

    public function PathPoints()
    {
        return $this->belongsToMany(PathPoint::class)->withPivot('order')->orderBy('pivot_order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
