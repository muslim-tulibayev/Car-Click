<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dealer extends Model
{
    use HasFactory;

    public $fillable = [
        "firstname",
        "lastname",
        "contact",
    ];

    public function tg_chat(): HasOne
    {
        return $this->hasOne(DealerChat::class, 'dealer_id');
    }

    public function auctions(): BelongsToMany
    {
        return $this->belongsToMany(Auction::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
