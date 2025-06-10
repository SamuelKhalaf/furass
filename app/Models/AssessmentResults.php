<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResults extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assessment_id',
        'answers',
        'score',
        'feedback',
    ];
}
