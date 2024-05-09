<?php

namespace App\Models;

use App\Constants\DB\ApplierDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Applier extends Model
{
    use HasFactory;
    protected $fillable = [
        ApplierDBConstants::EVENT_ID,
        ApplierDBConstants::AUTHOR_ID,
    ];
    protected $casts = [
        ApplierDBConstants::ID => 'string',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::orderedUuid();
        });
    }
    public $incrementing = false;
    protected $keyType = 'string';
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
