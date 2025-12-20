<?php

namespace App\Models\Traits;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait for models that belong to a school (tenant).
 * Automatically scopes queries to the current school context.
 */
trait BelongsToSchool
{
    /**
     * Boot the trait.
     */
    protected static function bootBelongsToSchool(): void
    {
        // Auto-set school_id when creating new records
        static::creating(function ($model) {
            if (empty($model->school_id) && session()->has('school_id')) {
                $model->school_id = session('school_id');
            }
        });
    }

    /**
     * Get the school that owns this model.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Scope query to current school.
     */
    public function scopeForSchool(Builder $query, ?int $schoolId = null): Builder
    {
        $schoolId = $schoolId ?? session('school_id');

        return $query->where('school_id', $schoolId);
    }

    /**
     * Scope query to active school.
     */
    public function scopeForActiveSchool(Builder $query): Builder
    {
        return $query->whereHas('school', function ($q) {
            $q->where('is_active', true);
        });
    }
}
