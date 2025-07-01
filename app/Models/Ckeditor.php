<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ckeditor extends Model
{
    use HasFactory;

    protected $fillable = ['page', 'variables_en', 'variables_ar'];

    protected $casts = [
        'variables_en' => 'array',
        'variables_ar' => 'array'
    ];

}
