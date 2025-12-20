<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Achievement model for student/school achievements.
 *
 * @property int $id
 * @property int $school_id
 * @property int $user_id
 * @property string $title
 * @property string $type
 * @property string $level
 * @property string|null $rank
 * @property string|null $participant_name
 * @property string|null $participant_class
 * @property string|null $description
 * @property string|null $image
 * @property \Carbon\Carbon|null $achievement_date
 * @property int $year
 * @property bool $is_published
 */
class Achievement extends Model implements HasMedia
{
    use HasFactory;
    use BelongsToSchool;
    use InteractsWithMedia;

    protected $fillable = [
        'school_id',
        'user_id',
        'title',
        'type',
        'level',
        'rank',
        'participant_name',
        'participant_class',
        'description',
        'image',
        'achievement_date',
        'year',
        'is_published',
    ];

    protected $casts = [
        'achievement_date' => 'date',
        'year' => 'integer',
        'is_published' => 'boolean',
    ];

    /**
     * Type labels in Indonesian.
     */
    public const TYPE_LABELS = [
        'akademik' => 'Akademik',
        'non_akademik' => 'Non-Akademik',
        'sekolah' => 'Sekolah',
    ];

    /**
     * Level labels in Indonesian.
     */
    public const LEVEL_LABELS = [
        'sekolah' => 'Tingkat Sekolah',
        'kecamatan' => 'Tingkat Kecamatan',
        'kota' => 'Tingkat Kota/Kabupaten',
        'provinsi' => 'Tingkat Provinsi',
        'nasional' => 'Tingkat Nasional',
        'internasional' => 'Tingkat Internasional',
    ];

    /**
     * Get type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? $this->type;
    }

    /**
     * Get level label.
     */
    public function getLevelLabelAttribute(): string
    {
        return self::LEVEL_LABELS[$this->level] ?? $this->level;
    }

    /**
     * Scope to published achievements.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope by year.
     */
    public function scopeYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope by type.
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    // Relationships

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
