<?php

namespace Database\Seeders;

use App\Models\Operator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operator = [
            "firstname" => 'Operator-name',
            "lastname" => 'Operator',
            // "contact" => '998997182029',
            "contact" => '998330060261',
            "password" => Hash::make('12345678'),
            "is_validated" => true,
        ];

        Operator::create($operator);
        // Operator::factory(20)->create();
    }
}
