<?php

namespace App\Models;

use App\Constants\DB\CountryDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        CountryDBConstants::NAME,
    ];
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
