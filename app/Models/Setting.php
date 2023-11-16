<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        "auction_expire_duration",
        "system_lang",
    ];

    public static function langsList(): array
    {
        return ['en', 'uz', 'ru'];
    }
}
