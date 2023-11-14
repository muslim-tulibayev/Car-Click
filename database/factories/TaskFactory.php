<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // "operation" => fake()->word(),
            // "taskable_type" => fake()->randomElement([Auction::class, Operator::class, Car::class]),
            // "taskable_id" => rand(1, 20),
            // "operator_id" => rand(1, 20),
        ];
    }
}
