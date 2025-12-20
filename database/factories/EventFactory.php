<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+2 months');
        $endDate = (clone $startDate)->modify('+' . rand(1, 3) . ' days');
        
        return [
            'school_id' => School::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_time' => '08:00',
            'end_time' => '12:00',
            'location' => $this->faker->address(),
            'is_all_day' => false,
            'color' => $this->faker->hexColor(),
        ];
    }

    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = $this->faker->dateTimeBetween('now', '+1 month');
            $endDate = (clone $startDate)->modify('+' . rand(1, 3) . ' days');
            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        });
    }

    public function past(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = $this->faker->dateTimeBetween('-2 months', '-1 day');
            $endDate = (clone $startDate)->modify('+' . rand(1, 3) . ' days');
            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        });
    }
}

