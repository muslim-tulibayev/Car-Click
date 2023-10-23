<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image = [
            "car_id" => 1,
            "file_id" => 'AgACAgIAAxkDAAILNWUg2j1IvoWwz9UgbBkVPBE9ItYmAAJWzjEbPsUJScWNoVCmxRihAQADAgADeAADMAQ',
        ];

        Image::create($image);
    }
}
