<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationNotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'notes',
        'report_pdf'
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
