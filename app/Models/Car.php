<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    public $fillable = [
        "company",
        "model",
        "year",
        "color",
        "condition",
        "status", // ['waiting_validation', 'on_sale', 'not_sold', 'didnt_sell', 'sold_out']
        "additional",
        "user_id",
        "dealer_id",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }
}
