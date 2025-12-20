<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'school_id',
        'plan',
        'starts_at',
        'expires_at',
        'is_active',
        'features',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function isActive(): bool
    {
        return $this->is_active && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function getPlanLabelAttribute(): string
    {
        return match($this->plan) {
            'basic' => 'Basic',
            'pro' => 'Professional',
            'enterprise' => 'Enterprise',
            default => 'Gratis',
        };
    }
}
