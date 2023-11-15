<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealerChat extends Model
{
    use HasFactory;

    public $fillable = [
        "id",
        "chat_id",
        "dealer_id",
        "action",
        "data",
        "lang",
    ];

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }

    public static function langsList()
    {
        return ['en', 'uz', 'ru'];
    }

    public static function fillables()
    {
        return (new static)->fillable;
    }
}
