<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Dealer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $auctions = Auction::all()->pluck('id');
        $dealaers = Dealer::all()->pluck('id');

        return [
            'auction_id' => fake()->randomElement($auctions),
            'dealer_id' => fake()->randomElement($dealaers),
            'price' => rand(100, 100000),
        ];
    }
}
