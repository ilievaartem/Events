<?php

namespace App\Models;

use App\Constants\DB\QuestionDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        QuestionDBConstants::CONTENT,
        QuestionDBConstants::EVENT_ID,
        QuestionDBConstants::AUTHOR_ID,
        QuestionDBConstants::PARENT_ID,
    ];
    protected $casts = [
        QuestionDBConstants::ID => 'string',
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
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, QuestionDBConstants::ID);
    }

}
