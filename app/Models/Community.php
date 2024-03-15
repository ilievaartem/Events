<?php

namespace App\Models;

use App\Constants\DB\CommunityDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    use HasFactory;
    protected $fillable = [
        CommunityDBConstants::NAME,
        CommunityDBConstants::REGION_ID
    ];
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
