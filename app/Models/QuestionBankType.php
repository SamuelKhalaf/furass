<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBankType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $casts = [
        'name' => 'array',
    ];
}
