<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ValuesQuestions extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id' , 'question_bank_type_id' , 'name'
    ];

    protected $casts = [
        'name'=>'array'
    ] ;

    public static function get_relation_data($idValue = null)
    {
        if ($idValue){
            return DB::table('values_questions')
                ->where('values_questions.id' , $idValue)
                ->leftJoin('values_questions as parent', 'values_questions.parent_id', '=', 'parent.id')
                ->first([
                    'values_questions.id as id',
                    'values_questions.name as valueQuestionName',
                    'parent.name as parentName',
                    'parent.id as parentID',
                ]);
        }
        return DB::table('values_questions')
            ->leftJoin('values_questions as parent', 'values_questions.parent_id', '=', 'parent.id')
            ->get([
                'values_questions.id as id',
                'values_questions.name as valueQuestionName',
                'parent.name as parentName'
            ]);
    }

}
