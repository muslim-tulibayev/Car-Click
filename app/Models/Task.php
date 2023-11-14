<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Task extends Model
{
    use HasFactory;

    public $fillable = [
        "operation",
        "operator_id",
        "taskable_type",
        "taskable_id",
        "is_done",
    ];

    public function taskable(): MorphTo
    {
        return $this->morphTo();
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TaskMsg::class);
    }



    public function getCreatedAtDate()
    {
        $date = new DateTime($this->created_at);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format('d.m.Y');
    }

    public function getCreatedAtClock()
    {
        $date = new DateTime($this->created_at);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format('H:i');
    }
}
