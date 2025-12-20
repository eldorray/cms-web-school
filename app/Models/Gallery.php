<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Gallery model for photo/video albums.
 *
 * @property int $id
 * @property int $school_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $cover_image
 * @property \Carbon\Carbon|null $event_date
 * @property bool $is_published
 * @property int $order
 */
class Gallery extends Model implements HasMedia
{
    use HasFactory;
    use BelongsToSchool;
    use InteractsWithMedia;

    protected $fillable = [
        'school_id',
        'user_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'event_date',
        'is_published',
        'order',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Gallery $gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }

    /**
     * Scope to published galleries.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope ordered galleries.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('event_date');
    }

    /**
     * Get items count.
     */
    public function getItemsCountAttribute(): int
    {
        return $this->items()->count();
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('images');
    }

    // Relationships

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class)->orderBy('order');
    }
}
