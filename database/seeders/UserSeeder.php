<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            "firstname" => 'User-name',
            "lastname" => 'User',
            "contact" => '998997182029',
        ];

        User::create($user);
        User::factory(19)->create();
    }
}
