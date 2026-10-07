<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->paragraph(),
            'duration' => fake()->numberBetween(1, 52),
            'fee' => fake()->randomFloat(2, 0, 5000),
            'difficulty' => fake()->randomElement(['Easy', 'Medium', 'Hard']),
            'is_active' => fake()->boolean(80),
        ];
    }
}
