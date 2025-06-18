<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'company_name',
        'location',
        'event_time',
        'description',
        'media_path',
        'document_path',
        'event_type'
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'event_program');
    }
}
