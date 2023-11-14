<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * @OA\Schema(schema="Auction", title="Auction Title",
 *   @OA\Property(property="car_id ", type="integer"),
 *   @OA\Property(property="starting_price", type="integer"),
 *   @OA\Property(property="life_cycle", type="enum['waiting_start', 'playing', 'waiting_confirma']"),
 *   @OA\Property(property="start", type="data"),
 *   @OA\Property(property="finish", type="data"),
 *   @OA\Property(property="join_btn_message_id", type="string"),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */
class Auction extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        "car_id",
        "starting_price",
        "life_cycle", // * ['waiting_start', 'playing', 'waiting_confirmation', 'finished']
        "start",
        "finish",
        "join_btn_message_id",
    ];

    public function taskable()
    {
        return $this->morphOne(Task::class, 'taskable');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function dealers(): BelongsToMany
    {
        return $this->belongsToMany(Dealer::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    // ------------------------- Additional ----------------------- //

    public function highestPriceOwner(): ?Dealer
    {
        $bid = $this->bids()->orderByDesc('id')->first();
        if ($bid)
            return $bid->dealer;
        return null;
    }

    public function highestPrice(): ?int
    {
        $bid = $this->bids()->orderByDesc('id')->first();
        if ($bid)
            return $bid->price;
        return null;
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

    public static function lifeCycleList()
    {
        return [
            'waiting_start',
            'playing',
            'waiting_confirmation',
            'finished'
        ];
    }
}
