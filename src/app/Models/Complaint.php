<?php

namespace App\Models;

use App\Constants\DB\ComplaintDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        ComplaintDBConstants::EVENT_ID,
        ComplaintDBConstants::AUTHOR_ID,
        ComplaintDBConstants::RESOLVER_ID,
        ComplaintDBConstants::CAUSE_MESSAGE,
        ComplaintDBConstants::CAUSE_DESCRIPTION,
        ComplaintDBConstants::RESOLVE_MESSAGE,
        ComplaintDBConstants::RESOLVE_DESCRIPTION,
    ];
    protected $casts = [
        ComplaintDBConstants::ID => 'string',
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
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
