<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperatorChat extends Model
{
    use HasFactory;

    public $fillable = [
        "id",
        "chat_id",
        "operator_id",
        "action",
        "data",
        "lang",
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'operator_id');
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
