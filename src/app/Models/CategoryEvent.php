<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'event_id',
    ];
    protected $table = 'category_event';

}
