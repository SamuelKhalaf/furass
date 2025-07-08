<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Questions extends Model
{
    use HasFactory;
    protected $fillable = ['bank_id', 'value_id', 'text', 'type', 'action', 'order'];

    protected $casts = [
        'text'=>'array'
    ];

    public static function getData($bank_id)
    {
        return DB::table('questions')
            ->where('bank_id', $bank_id)
            ->join('question_bank_types' , 'questions.bank_id' , '=' ,'question_bank_types.id')
            ->join('values_questions' , 'questions.value_id', '=' ,'values_questions.id')
            ->get(['questions.id' , 'questions.text' , 'questions.type','question_bank_types.name as bank' , 'values_questions.name as value']);
    }
}
