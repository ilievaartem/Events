<?php

namespace App\Models;

use App\Constants\DB\MessageDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        MessageDBConstants::TEXT,
        MessageDBConstants::AUTHOR_ID,
        MessageDBConstants::CHAT_ID,

    ];
    protected $casts = [
        MessageDBConstants::ID => 'string',
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
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
