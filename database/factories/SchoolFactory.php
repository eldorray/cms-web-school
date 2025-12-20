<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SchoolFactory extends Factory
{
    protected $model = School::class;

    public function definition(): array
    {
        $name = $this->faker->company() . ' School';
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'domain' => Str::slug($name) . '.localhost',
            'school_level' => $this->faker->randomElement(['SD', 'SMP', 'MI', 'MTs']),
            'npsn' => $this->faker->numerify('########'),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->url(),
            'theme_primary_color' => '#3B82F6',
            'theme_secondary_color' => '#6366F1',
            'theme_accent_color' => '#F59E0B',
            'is_active' => true,
            'social_media' => [
                'facebook' => 'https://facebook.com/' . $this->faker->userName(),
                'instagram' => 'https://instagram.com/' . $this->faker->userName(),
            ],
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
