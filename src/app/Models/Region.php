<?php

namespace App\Models;

use App\Constants\DB\RegionDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;
    protected $fillable = [
        RegionDBConstants::NAME,
        RegionDBConstants::COUNTRY_ID
    ];
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function communities(): HasMany
    {
        return $this->hasMany(Community::class);
    }
}
