<?php

namespace App\Models;

use App\Constants\DB\PlaceDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{
    use HasFactory;
    protected $fillable = [
        PlaceDBConstants::NAME,
        PlaceDBConstants::COMMUNITY_ID,
        PlaceDBConstants::TYPE
    ];
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
