<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathPoint extends Model
{
    use HasFactory;

    protected $table = 'path_points';

    protected $fillable = [
        'title_ar',
        'title_en',
        'table_name',
        'meta',
        'grade',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function Programs()
    {
        return $this->belongsToMany(Program::class)->withPivot('order')->orderBy('pivot_order');
    }

    // In your PathPoint model
    public function studentPathProgress()
    {
        return $this->hasMany(StudentPathProgress::class);
    }
}
