<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'contact',
    ];

    // protected $hidden = [
    //     'password',
    // ];

    // public function cars(): MorphMany
    // {
    //     return $this->morphMany(Car::class, 'user');
    // }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function tg_chat(): HasOne
    {
        return $this->hasOne(UserChat::class, 'user_id');
    }

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];

    public static function fillables()
    {
        return (new static)->fillable;
    }
}
