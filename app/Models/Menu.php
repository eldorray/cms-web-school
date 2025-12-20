<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Menu model for navigation menu builder.
 *
 * @property int $id
 * @property int $school_id
 * @property int|null $parent_id
 * @property string $title
 * @property string|null $url
 * @property string $target
 * @property string|null $icon
 * @property string $location
 * @property int $order
 * @property bool $is_active
 */
class Menu extends Model
{
    use HasFactory;
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'parent_id',
        'title',
        'url',
        'target',
        'icon',
        'location',
        'order',
        'is_active',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Menu location labels.
     */
    public const LOCATION_LABELS = [
        'header' => 'Header Navigation',
        'footer' => 'Footer Navigation',
        'sidebar' => 'Sidebar Navigation',
    ];

    /**
     * Get location label.
     */
    public function getLocationLabelAttribute(): string
    {
        return self::LOCATION_LABELS[$this->location] ?? $this->location;
    }

    /**
     * Check if menu item has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Scope to active menu items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to root menu items (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope by location.
     */
    public function scopeLocation($query, string $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope ordered menu items.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get menu tree for a location.
     */
    public static function getTree(int $schoolId, string $location): \Illuminate\Support\Collection
    {
        return self::where('school_id', $schoolId)
            ->where('location', $location)
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }

    // Relationships

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }
}
