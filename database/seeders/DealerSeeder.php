<?php

namespace Database\Seeders;

use App\Models\Dealer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dealer = [
            "firstname" => 'Dealer-name',
            "lastname" => 'Dealer',
            "contact" => '998997182029',
            "is_validated" => true,
        ];

        Dealer::create($dealer);
        Dealer::factory(20)->create();
    }
}
