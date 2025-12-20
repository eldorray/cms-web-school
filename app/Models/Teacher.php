<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Teacher model for school personnel.
 *
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property string|null $nip
 * @property string|null $nuptk
 * @property string $position
 * @property string|null $position_detail
 * @property string|null $subject
 * @property string|null $education
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $photo
 * @property string|null $bio
 * @property int $order
 * @property bool $is_active
 */
class Teacher extends Model implements HasMedia
{
    use HasFactory;
    use BelongsToSchool;
    use InteractsWithMedia;

    protected $fillable = [
        'school_id',
        'name',
        'nip',
        'nuptk',
        'position',
        'position_detail',
        'subject',
        'education',
        'phone',
        'email',
        'photo',
        'bio',
        'order',
        'is_active',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Position labels in Indonesian.
     */
    public const POSITION_LABELS = [
        'kepala_sekolah' => 'Kepala Sekolah',
        'wakil_kepala' => 'Wakil Kepala Sekolah',
        'guru' => 'Guru',
        'staff_tu' => 'Staff Tata Usaha',
        'pustakawan' => 'Pustakawan',
        'laboran' => 'Laboran',
        'satpam' => 'Satpam',
        'petugas_kebersihan' => 'Petugas Kebersihan',
        'lainnya' => 'Lainnya',
    ];

    /**
     * Get position label.
     */
    public function getPositionLabelAttribute(): string
    {
        return self::POSITION_LABELS[$this->position] ?? $this->position;
    }

    /**
     * Scope to active teachers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered teachers.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * Scope by position.
     */
    public function scopePosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
