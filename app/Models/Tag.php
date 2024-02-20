<?php

namespace App\Models;

use App\Constants\DB\TagDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        TagDBConstants::NAME,
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
