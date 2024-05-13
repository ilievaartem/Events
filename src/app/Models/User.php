<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Constants\DB\ApplierDBConstants;
use App\Constants\DB\ChatDBConstants;
use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\ComplaintDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\InteresterDBConstants;
use App\Constants\DB\MediaDBConstants;
use App\Constants\DB\MessageDBConstants;
use App\Constants\DB\QuestionDBConstants;
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
        return [
            $this->name
        ];
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, EventDBConstants::AUTHOR_ID);
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, QuestionDBConstants::AUTHOR_ID);
    }
    public function media(): HasMany
    {
        return $this->hasMany(Media::class, MediaDBConstants::AUTHOR_ID);
    }
    public function interesters(): HasMany
    {
        return $this->hasMany(Interester::class, InteresterDBConstants::AUTHOR_ID);
    }
    public function appliers(): HasMany
    {
        return $this->hasMany(Applier::class, ApplierDBConstants::AUTHOR_ID);
    }
    public function chatAuthors(): HasMany
    {
        return $this->hasMany(Chat::class, ChatDBConstants::AUTHOR_ID);
    }
    public function chatMembers(): HasMany
    {
        return $this->hasMany(Chat::class, ChatDBConstants::MEMBER_ID);
    }
    public function chatLastMessageAuthors(): HasMany
    {
        return $this->hasMany(Chat::class, ChatDBConstants::LAST_MESSAGE_AUTHOR_ID);
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, MessageDBConstants::AUTHOR_ID);
    }
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, ComplaintDBConstants::AUTHOR_ID);
    }
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class, CommentDBConstants::AUTHOR_ID);
    }
    public function question(): HasMany
    {
        return $this->hasMany(Question::class, QuestionDBConstants::AUTHOR_ID);
    }
}
