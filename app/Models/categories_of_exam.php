<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories_of_exam extends Model
{
    use HasFactory;

    protected $fillable = ['cat_name'];
    protected $casts = [
        'cat_name' => 'array',
    ];
}
