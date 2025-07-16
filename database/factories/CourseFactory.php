<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
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
            'user_id'     => \App\Models\User::factory(),
            'name' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph(),
            'duration' => $this->faker->numberBetween(1, 52), // Duration in weeks
            'price' => $this->faker->randomFloat(2, 0, 1000), // Price between 0 and 1000
        ];
    }
}
