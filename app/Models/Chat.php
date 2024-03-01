<?php

namespace App\Models;

use App\Constants\DB\ChatDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        ChatDBConstants::TOPIC,
        ChatDBConstants::AUTHOR_ID,
        ChatDBConstants::EVENT_ID,
        ChatDBConstants::MEMBER_ID,
        ChatDBConstants::LAST_MESSAGE_TEXT,
        ChatDBConstants::LAST_MESSAGE_AUTHOR_ID,
    ];
    protected $casts = [
        ChatDBConstants::ID => 'string',
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
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function message(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
