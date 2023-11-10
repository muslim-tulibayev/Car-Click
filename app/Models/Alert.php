<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    public $fillable = [
        'type',
        'message',
    ];

    public function getCreatedAt()
    {
        $date = new DateTime($this->created_at);
        return  $date->setTimezone(new DateTimeZone('GMT+5'))->format('Y.m.d H:i');
    }
}
