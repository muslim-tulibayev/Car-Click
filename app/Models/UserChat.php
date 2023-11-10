<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserChat extends Model
{
    use HasFactory;

    public $fillable = [
        "chat_id",
        "user_id",
        "action",
        "data",
        "lang", // * ['en', 'uz', 'ru'], default('en')
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function langsList()
    {
        return ['en', 'uz', 'ru'];
    }
}
