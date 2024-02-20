<?php

namespace App\Models;

use App\Constants\DB\CommentDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        CommentDBConstants::EVENT_ID,
        CommentDBConstants::AUTHOR_ID,
        CommentDBConstants::CONTENT
    ];
    protected $casts = [
        CommentDBConstants::ID => 'string',
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
