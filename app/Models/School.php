<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * School model - represents a tenant in the multi-tenant system.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $domain
 * @property string $school_level
 * @property string|null $npsn
 * @property string|null $logo
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property string $theme_primary_color
 * @property string $theme_secondary_color
 * @property string $theme_accent_color
 * @property array|null $social_media
 * @property array|null $settings
 * @property bool $is_active
 * @property \Carbon\Carbon|null $subscription_until
 */
class School extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'school_level',
        'npsn',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'theme_primary_color',
        'theme_secondary_color',
        'theme_accent_color',
        'social_media',
        'settings',
        'is_active',
        'subscription_until',
    ];

    protected $casts = [
        'social_media' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'subscription_until' => 'datetime',
    ];

    /**
     * Get the school level label in Indonesian.
     */
    public function getSchoolLevelLabelAttribute(): string
    {
        return match ($this->school_level) {
            'SD' => 'Sekolah Dasar',
            'MI' => 'Madrasah Ibtidaiyah',
            'SMP' => 'Sekolah Menengah Pertama',
            'MTs' => 'Madrasah Tsanawiyah',
            default => $this->school_level,
        };
    }

    /**
     * Check if school subscription is active.
     */
    public function isSubscriptionActive(): bool
    {
        if (is_null($this->subscription_until)) {
            return true; // No expiry = free/unlimited
        }

        return $this->subscription_until->isFuture();
    }

    /**
     * Get CSS variables for dynamic theming.
     */
    public function getThemeCssVariables(): string
    {
        return sprintf(
            ':root { --color-primary: %s; --color-secondary: %s; --color-accent: %s; }',
            $this->theme_primary_color,
            $this->theme_secondary_color,
            $this->theme_accent_color
        );
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('favicon')->singleFile();
    }

    // Relationships

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function ppdbPeriods(): HasMany
    {
        return $this->hasMany(PpdbPeriod::class);
    }

    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function subscription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Get a setting value by key.
     */
    public function getSetting(string $key, mixed $default = null): mixed
    {
        $setting = $this->settings()->where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    /**
     * Set a setting value.
     */
    public function setSetting(string $key, mixed $value, string $type = 'text', string $group = 'general'): void
    {
        $this->settings()->updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );
    }
}
