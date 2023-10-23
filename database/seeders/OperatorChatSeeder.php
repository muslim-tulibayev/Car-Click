<?php

namespace Database\Seeders;

use App\Models\OperatorChat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatorChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chat = [
            "chat_id" => '1117894175',
            "operator_id" => 1,
            "action" => null,
            "data" => null,
            "lang" => fake()->randomElement(['en', 'uz', 'ru']),
        ];

        OperatorChat::create($chat);
    }
}
