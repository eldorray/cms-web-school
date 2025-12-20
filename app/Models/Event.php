<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Event model for academic calendar and agenda.
 *
 * @property int $id
 * @property int $school_id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon|null $end_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property bool $is_all_day
 * @property string|null $location
 * @property string $color
 * @property bool $is_published
 */
class Event extends Model
{
    use HasFactory;
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'user_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'is_all_day',
        'location',
        'color',
        'is_published',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_all_day' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * Scope to published events.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date');
    }

    /**
     * Scope to events in a specific month.
     */
    public function scopeInMonth($query, int $year, int $month)
    {
        return $query->whereYear('start_date', $year)
            ->whereMonth('start_date', $month);
    }

    /**
     * Check if event is multi-day.
     */
    public function isMultiDay(): bool
    {
        return $this->end_date && $this->end_date->gt($this->start_date);
    }

    /**
     * Get formatted date range.
     */
    public function getFormattedDateAttribute(): string
    {
        if ($this->isMultiDay()) {
            return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
        }

        return $this->start_date->format('d M Y');
    }

    // Relationships

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
