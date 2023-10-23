<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "car_id" => rand(1, 20),
            "starting_price" => rand(100, 100000),
            "highest_price" => rand(0, 100000),
            "highest_price_owner_id" => rand(1, 20),
            "life_cycle" => fake()->randomElement(['waiting_start', 'playing', 'waiting_confirmation', 'finished']),
            "start" => fake()->date('Y-m-d H:i:s'),
            "finish" => fake()->date('Y-m-d H:i:s'),
            "join_btn_message_id" => rand(100000, 999999),
        ];
    }
}
