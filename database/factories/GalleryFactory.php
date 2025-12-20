<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        
        return [
            'school_id' => School::factory(),
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'event_date' => $this->faker->date(),
            'is_published' => true,
        ];
    }
}

