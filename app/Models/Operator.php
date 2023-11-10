<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Operator extends Model
{
    use HasFactory;

    public $fillable = [
        "firstname",
        "lastname",
        "contact",
        "password",
        "is_validated",
    ];

    protected $hidden = [
        'password',
    ];

    public function tg_chat(): HasOne
    {
        return $this->hasOne(OperatorChat::class, 'operator_id');
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    public function queue(): HasOne
    {
        return $this->hasOne(Queue::class);
    }

    public function queueable()
    {
        return $this->morphOne(Queue::class, 'queueable');
    }
}
