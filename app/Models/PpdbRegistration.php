<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * PPDB Registration model for student enrollment.
 *
 * @property int $id
 * @property int $school_id
 * @property int $ppdb_period_id
 * @property string $registration_number
 * @property string $student_name
 * @property string|null $nisn
 * @property \Carbon\Carbon $birth_date
 * @property string $birth_place
 * @property string $gender
 * @property string|null $religion
 * @property string $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $previous_school
 * @property string $parent_name
 * @property string $parent_phone
 * @property string|null $parent_email
 * @property string|null $parent_occupation
 * @property string|null $parent_address
 * @property array|null $documents
 * @property string $status
 * @property string|null $notes
 * @property \Carbon\Carbon|null $verified_at
 */
class PpdbRegistration extends Model
{
    use HasFactory;
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'ppdb_period_id',
        'registration_number',
        'student_name',
        'nisn',
        'birth_date',
        'birth_place',
        'gender',
        'religion',
        'address',
        'phone',
        'email',
        'previous_school',
        'parent_name',
        'parent_phone',
        'parent_email',
        'parent_occupation',
        'parent_address',
        'documents',
        'status',
        'notes',
        'verified_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'documents' => 'array',
        'verified_at' => 'datetime',
    ];

    /**
     * Status labels in Indonesian.
     */
    public const STATUS_LABELS = [
        'pending' => 'Menunggu Verifikasi',
        'verified' => 'Terverifikasi',
        'accepted' => 'Diterima',
        'rejected' => 'Ditolak',
        'enrolled' => 'Terdaftar',
    ];

    /**
     * Status colors for UI.
     */
    public const STATUS_COLORS = [
        'pending' => 'yellow',
        'verified' => 'blue',
        'accepted' => 'green',
        'rejected' => 'red',
        'enrolled' => 'purple',
    ];

    protected static function booted(): void
    {
        static::creating(function (PpdbRegistration $registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = self::generateRegistrationNumber($registration->school_id);
            }
        });
    }

    /**
     * Generate unique registration number.
     */
    public static function generateRegistrationNumber(int $schoolId): string
    {
        $year = now()->year;
        $count = self::where('school_id', $schoolId)
            ->whereYear('created_at', $year)
            ->count() + 1;

        return sprintf('REG-%d-%s-%04d', $schoolId, $year, $count);
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    /**
     * Get status color.
     */
    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    /**
     * Get gender label.
     */
    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Scope by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to pending registrations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to accepted registrations.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    // Relationships

    public function period(): BelongsTo
    {
        return $this->belongsTo(PpdbPeriod::class, 'ppdb_period_id');
    }
}
