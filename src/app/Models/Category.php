<?php

namespace App\Models;

use App\Constants\DB\CategoryDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        CategoryDBConstants::NAME,

    ];
    protected $hidden = ['pivot'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

}
