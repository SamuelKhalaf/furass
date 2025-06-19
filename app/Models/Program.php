<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_program');
    }

    public function PathPoints()
    {
        return $this->belongsToMany(PathPoint::class)->withPivot('order')->orderBy('pivot_order');
    }
}
