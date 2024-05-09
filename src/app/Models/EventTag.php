<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'tag_id',
        'event_id',
    ];
    protected $table = 'event_tag';
}
