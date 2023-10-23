<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auction extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        "car_id",
        "starting_price",
        "highest_price",
        "highest_price_owner_id",
        "life_cycle", // * ['waiting_start', 'playing', 'waiting_confirmation', 'finished']
        "start",
        "finish",
        "join_btn_message_id",
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function dealers()
    {
        return $this->belongsToMany(Dealer::class);
    }

    public function highestPriceOwner()
    {
        return $this->belongsTo(Dealer::class, 'highest_price_owner_id', 'id');
    }

    public function getFinish(string $finish = 'Y.m.d H:i')
    {
        $date = new DateTime($this->finish);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format($finish);
    }

    public function getStart(string $finish = 'Y.m.d H:i')
    {
        $date = new DateTime($this->start);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format($finish);
    }

    public function getStartDate()
    {
        $date = new DateTime($this->start);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format('d.m.Y');
    }

    public function getStartClock()
    {
        $date = new DateTime($this->start);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format('H:i');
    }

    public function getFinishDate()
    {
        $date = new DateTime($this->finish);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format('d.m.Y');
    }

    public function getFinishClock()
    {
        $date = new DateTime($this->finish);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format('H:i');
    }

    public function lifeCycleList()
    {
        return [
            'waiting_start',
            'playing',
            'waiting_confirmation',
            'finished'
        ];
    }
}
