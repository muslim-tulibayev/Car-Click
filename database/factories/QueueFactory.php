<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Car;
use App\Models\Operator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Queue>
 */
class QueueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "operation" => fake()->word(),
            "queueable_type" => fake()->randomElement([Auction::class, Operator::class, Car::class]),
            "queueable_id" => rand(1, 20),
            "operator_id" => rand(1, 20),
        ];
    }
}
