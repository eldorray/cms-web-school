<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Download model for file download center.
 *
 * @property int $id
 * @property int $school_id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string $file_path
 * @property string $file_name
 * @property string|null $file_type
 * @property int $file_size
 * @property string $category
 * @property int $download_count
 * @property bool $is_published
 * @property int $order
 */
class Download extends Model implements HasMedia
{
    use HasFactory;
    use BelongsToSchool;
    use InteractsWithMedia;

    protected $fillable = [
        'school_id',
        'user_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'category',
        'download_count',
        'is_published',
        'order',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'download_count' => 'integer',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Category labels in Indonesian.
     */
    public const CATEGORY_LABELS = [
        'formulir' => 'Formulir',
        'laporan' => 'Laporan',
        'materi' => 'Materi',
        'pengumuman' => 'Pengumuman',
        'lainnya' => 'Lainnya',
    ];

    /**
     * Get category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_LABELS[$this->category] ?? $this->category;
    }

    /**
     * Get human-readable file size.
     */
    public function getFileSizeForHumansAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /**
     * Increment download count.
     */
    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
    }

    /**
     * Scope to published downloads.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope ordered downloads.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('created_at');
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')->singleFile();
    }

    // Relationships

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
