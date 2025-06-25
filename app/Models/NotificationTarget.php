<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NotificationTarget extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'notification_id',
        'target_type',
        'target_id'
    ];

    /**
     * @return BelongsTo
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    /**
     * @return MorphTo
     */
    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}
