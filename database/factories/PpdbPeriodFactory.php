<?php

namespace Database\Factories;

use App\Models\PpdbPeriod;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class PpdbPeriodFactory extends Factory
{
    protected $model = PpdbPeriod::class;

    public function definition(): array
    {
        $year = date('Y');
        
        return [
            'school_id' => School::factory(),
            'name' => "PPDB Tahun Ajaran {$year}/" . ($year + 1),
            'academic_year' => "{$year}/" . ($year + 1),
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(60),
            'quota' => $this->faker->numberBetween(50, 200),
            'requirements' => "1. Ijazah/SKL\n2. Kartu Keluarga\n3. Akta Kelahiran\n4. Foto 3x4",
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => now()->subDays(30),
        ]);
    }
}
