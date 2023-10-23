<?php

namespace Database\Seeders;

use App\Models\UserChat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chat = [
            "chat_id" => '1117894175',
            "user_id" => 1,
            "action" => null,
            "data" => null,
            "lang" => fake()->randomElement(['en', 'uz', 'ru']),
        ];

        UserChat::create($chat);
    }
}
