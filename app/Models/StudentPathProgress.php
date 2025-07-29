<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPathProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'program_id',
        'path_point_id',
        'status',
        'completion_date',
        'attempt_count',
        'time_spent',
        'order',
    ];

    // Status Constants
    public const STATUS_LOCKED = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_COMPLETED = 3;
    public const STATUS_SKIPPED = 4;

    // Status Labels
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_LOCKED    => 'locked',
            self::STATUS_ACTIVE    => 'active',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_SKIPPED   => 'skipped',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'unknown';
    }

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function pathPoint()
    {
        return $this->belongsTo(PathPoint::class);
    }
}

