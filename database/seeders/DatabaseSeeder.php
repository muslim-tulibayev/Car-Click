<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingSeeder::class,
            OperatorSeeder::class,

            // DealerSeeder::class,
            // UserSeeder::class,
            // CarSeeder::class,
            // AuctionSeeder::class,
        ]);
    }
}
