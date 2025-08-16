<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionBankValue extends Model
{
    use HasFactory;
    protected $fillable = ['bank_id' , 'value_id' , 'percentage'];

    public static function get_bank_values($bank_id)
    {
        return DB::table('question_bank_values')
            ->where('bank_id' , $bank_id)
            ->join('question_bank_types' ,'question_bank_values.bank_id' , '=','question_bank_types.id')
            ->join('values_questions' ,'question_bank_values.value_id' , '=','values_questions.id')
            ->get([
                'question_bank_values.id as id' , 'question_bank_values.percentage',
                'question_bank_types.name as bank_name' , 'question_bank_types.id as bank_id' ,
                'values_questions.name as value_name' , 'values_questions.id as value_id' ,
            ]);
    }
}
