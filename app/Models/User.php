<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Constants\DB\UserDBConstants;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        UserDBConstants::ID => 'string',
        UserDBConstants::EMAIL_VERIFIED_AT => 'datetime',
        UserDBConstants::PASSWORD => 'hashed',
    ];
    protected $fillable = [
        UserDBConstants::NAME,
        UserDBConstants::EMAIL,
        UserDBConstants::ROLE,
        UserDBConstants::TELEPHONE,
        UserDBConstants::AVATAR,
        UserDBConstants::PASSWORD,
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::orderedUuid();
        });
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
    public function interesters(): HasMany
    {
        return $this->hasMany(Interester::class);
    }
    public function appliers(): HasMany
    {
        return $this->hasMany(Applier::class);
    }

}
