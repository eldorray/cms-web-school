<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Setting model for per-school settings.
 *
 * @property int $id
 * @property int $school_id
 * @property string $key
 * @property string|null $value
 * @property string $type
 * @property string $group
 */
class Setting extends Model
{
    use HasFactory;
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * Setting types.
     */
    public const TYPES = [
        'text' => 'Text',
        'textarea' => 'Textarea',
        'number' => 'Number',
        'boolean' => 'Boolean',
        'select' => 'Select',
        'color' => 'Color',
        'image' => 'Image',
        'json' => 'JSON',
    ];

    /**
     * Setting groups.
     */
    public const GROUPS = [
        'general' => 'Umum',
        'seo' => 'SEO',
        'social' => 'Media Sosial',
        'contact' => 'Kontak',
        'ppdb' => 'PPDB',
    ];

    /**
     * Get typed value.
     */
    public function getTypedValueAttribute(): mixed
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'number' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /**
     * Get a setting value by key for a school.
     */
    public static function getValue(int $schoolId, string $key, mixed $default = null): mixed
    {
        $setting = self::where('school_id', $schoolId)
            ->where('key', $key)
            ->first();

        return $setting?->typed_value ?? $default;
    }

    /**
     * Set a setting value for a school.
     */
    public static function setValue(int $schoolId, string $key, mixed $value, string $type = 'text', string $group = 'general'): void
    {
        if ($type === 'json' && is_array($value)) {
            $value = json_encode($value);
        } elseif ($type === 'boolean') {
            $value = $value ? '1' : '0';
        }

        self::updateOrCreate(
            ['school_id' => $schoolId, 'key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );
    }

    /**
     * Scope by group.
     */
    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}
