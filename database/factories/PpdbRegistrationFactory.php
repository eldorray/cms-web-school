<?php

namespace Database\Factories;

use App\Models\PpdbRegistration;
use App\Models\PpdbPeriod;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class PpdbRegistrationFactory extends Factory
{
    protected $model = PpdbRegistration::class;

    public function definition(): array
    {
        return [
            'school_id' => School::factory(),
            'ppdb_period_id' => PpdbPeriod::factory(),
            'registration_number' => 'PPDB-' . date('Y') . '-' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'student_name' => $this->faker->name(),
            'nisn' => $this->faker->numerify('##########'),
            'birth_place' => $this->faker->city(),
            'birth_date' => $this->faker->date('Y-m-d', '-8 years'),
            'gender' => $this->faker->randomElement(['L', 'P']),
            'religion' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
            'address' => $this->faker->address(),
            'previous_school' => $this->faker->company() . ' School',
            'parent_name' => $this->faker->name('male') . ' / ' . $this->faker->name('female'),
            'parent_phone' => $this->faker->phoneNumber(),
            'parent_email' => $this->faker->safeEmail(),
            'parent_occupation' => $this->faker->jobTitle(),
            'status' => 'pending',
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'accepted',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}

