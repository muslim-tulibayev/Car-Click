<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operator>
 */
class OperatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "firstname" => fake()->firstName(),
            "lastname" => fake()->lastName(),
            "contact" => fake()->phoneNumber(),
            "password" => Hash::make('12345678'),
            "is_validated" => fake()->boolean(),
        ];
    }
}
