<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "company" => fake()->word(),
            "model" => fake()->word(),
            "year" => rand(1930, 2023),
            "color" => fake()->word(),
            "condition" => fake()->randomElement(['bad', 'good', 'new']),
            "status" => fake()->randomElement(['waiting_validation', 'on_sale', 'sold_out', 'not_sold']),
            "additional" => fake()->text(),
            "user_id" => rand(1, 20),
            "dealer_id" => rand(1, 20),
        ];
    }
}
