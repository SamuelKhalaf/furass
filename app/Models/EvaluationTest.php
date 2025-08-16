<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationTest extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'question_id', 'bank_id', 'value_id', 'evaluation', 'trying'];


}
