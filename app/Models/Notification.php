<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['created_at_human'];

    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * @return HasMany
     */
    public function targets(): HasMany
    {
        return $this->hasMany(NotificationTarget::class);
    }

    /**
     * @return HasMany
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(NotificationStatus::class);
    }
}
