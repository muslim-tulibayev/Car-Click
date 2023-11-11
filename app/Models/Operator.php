<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(schema="Operator", title="Operator Title",
 *   @OA\Property(property="firstname", type="string"),
 *   @OA\Property(property="lastname", type="string"),
 *   @OA\Property(property="contact", type="contact"),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */

class Operator extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
