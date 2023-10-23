<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $car = [
            "company" => 'Tesla',
            "model" => 'Model-S',
            "year" => 2021,
            "color" => 'Red',
            "condition" => 'new', //', ['bad', 'good', 'new']);
            "status" => 'on_sale', //', ['waiting_validation', 'on_sale', 'sold_out', 'not_sold'])->default('waiting_validation');
            "additional" => fake()->text(),
            "user_id" => 1,
            "dealer_id" => null,
        ];

        Car::create($car);
        Car::factory(20)->create();
    }
}
