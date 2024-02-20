<?php

namespace App\Models;

use App\Constants\DB\MediaDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory;


    protected $fillable = [
        MediaDBConstants::PATH,
        MediaDBConstants::TYPE,
        MediaDBConstants::EVENT_ID,
        MediaDBConstants::AUTHOR_ID,
        MediaDBConstants::COMMENT_ID,
    ];
    protected $casts = [
        MediaDBConstants::ID => 'string',
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
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
