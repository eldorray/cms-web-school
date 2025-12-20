<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Page model for static pages.
 *
 * @property int $id
 * @property int $school_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $featured_image
 * @property string $template
 * @property bool $is_published
 * @property bool $show_in_menu
 * @property int $order
 * @property array|null $meta
 */
class Page extends Model implements HasMedia
{
    use HasFactory;
    use BelongsToSchool;
    use InteractsWithMedia;

    protected $fillable = [
        'school_id',
        'user_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'template',
        'is_published',
        'show_in_menu',
        'order',
        'meta',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'order' => 'integer',
        'meta' => 'array',
    ];

    /**
     * Available page templates.
     */
    public const TEMPLATES = [
        'default' => 'Default',
        'full_width' => 'Full Width',
        'sidebar_left' => 'Sidebar Left',
        'sidebar_right' => 'Sidebar Right',
    ];

    protected static function booted(): void
    {
        static::creating(function (Page $page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Get template label.
     */
    public function getTemplateLabelAttribute(): string
    {
        return self::TEMPLATES[$this->template] ?? $this->template;
    }

    /**
     * Scope to published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to pages shown in menu.
     */
    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    /**
     * Scope ordered pages.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('title');
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->singleFile();
        $this->addMediaCollection('content_images');
    }

    // Relationships

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
