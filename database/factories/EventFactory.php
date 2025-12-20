<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+2 months');
        
        return [
            'school_id' => School::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'start_date' => $startDate,
            'end_date' => $this->faker->dateTimeBetween($startDate, '+3 days'),
            'start_time' => '08:00',
            'end_time' => '12:00',
            'location' => $this->faker->address(),
            'is_all_day' => false,
            'color' => $this->faker->hexColor(),
        ];
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ]);
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => $this->faker->dateTimeBetween('-2 months', '-1 day'),
        ]);
    }
}
