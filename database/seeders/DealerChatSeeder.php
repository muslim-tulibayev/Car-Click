<?php

namespace Database\Seeders;

use App\Models\DealerChat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealerChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chat = [
            "chat_id" => '1117894175',
            "dealer_id" => 1,
            "action" => null,
            "data" => null,
            "lang" => fake()->randomElement(['en', 'uz', 'ru']),
        ];

        DealerChat::create($chat);
    }
}
