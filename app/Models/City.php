<?php

namespace App\Models;

use App\Constants\DB\CityDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        CityDBConstants::NAME,
        CityDBConstants::COUNTRY_ID,
    ];
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
