<?php

namespace App\Models;

use App\Constants\DB\CategoryDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        CategoryDBConstants::NAME,
        CategoryDBConstants::PARENT_ID,
    ];
    protected $hidden = ['pivot'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

}
