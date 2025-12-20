<?php

namespace Database\Factories;

use App\Models\Achievement;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition(): array
    {
        return [
            'school_id' => School::factory(),
            'title' => $this->faker->sentence(4),
            'type' => $this->faker->randomElement(['academic', 'sports', 'arts', 'other']),
            'level' => $this->faker->randomElement(['school', 'district', 'province', 'national', 'international']),
            'rank' => $this->faker->randomElement(['Juara 1', 'Juara 2', 'Juara 3', 'Juara Harapan']),
            'year' => $this->faker->year(),
            'participant_name' => $this->faker->name(),
            'participant_class' => $this->faker->randomElement(['6A', '5B', '4C']),
            'description' => $this->faker->paragraph(),
            'is_published' => true,
        ];
    }
}
