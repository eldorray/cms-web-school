<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * GalleryItem model for individual gallery items.
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $type
 * @property string $file_path
 * @property string|null $thumbnail
 * @property string|null $caption
 * @property string|null $video_url
 * @property int $order
 */
class GalleryItem extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'gallery_id',
        'type',
        'file_path',
        'thumbnail',
        'caption',
        'video_url',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Check if item is a video.
     */
    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    /**
     * Check if item is an image.
     */
    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')->singleFile();
        $this->addMediaCollection('thumbnail')->singleFile();
    }

    // Relationships

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
}
