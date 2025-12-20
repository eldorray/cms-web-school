<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * PPDB Period model for enrollment periods.
 *
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property string $academic_year
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string|null $requirements
 * @property string|null $description
 * @property int|null $quota
 * @property bool $is_active
 */
class PpdbPeriod extends Model
{
    use HasFactory;
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'name',
        'academic_year',
        'start_date',
        'end_date',
        'requirements',
        'description',
        'quota',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'quota' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Check if registration is open.
     */
    public function isOpen(): bool
    {
        return $this->is_active
            && now()->between($this->start_date, $this->end_date);
    }

    /**
     * Get remaining quota.
     */
    public function getRemainingQuotaAttribute(): ?int
    {
        if (is_null($this->quota)) {
            return null;
        }

        return max(0, $this->quota - $this->registrations()->accepted()->count());
    }

    /**
     * Scope to active periods.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to currently open periods.
     */
    public function scopeOpen($query)
    {
        return $query->active()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    // Relationships

    public function registrations(): HasMany
    {
        return $this->hasMany(PpdbRegistration::class);
    }
}
