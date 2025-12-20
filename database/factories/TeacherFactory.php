<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'school_id' => School::factory(),
            'name' => $this->faker->name() . ', S.Pd',
            'nip' => $this->faker->numerify('##################'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'position' => $this->faker->randomElement(['kepala_sekolah', 'wakil_kepala', 'guru', 'staff_tu', 'pustakawan', 'laboran', 'satpam', 'petugas_kebersihan', 'lainnya']),
            'position_detail' => null,
            'subject' => $this->faker->randomElement(['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Bahasa Inggris']),
            'bio' => $this->faker->paragraph(),
            'is_active' => true,
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function principal(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => 'kepala_sekolah',
            'position_detail' => 'Kepala Sekolah',
        ]);
    }
}

