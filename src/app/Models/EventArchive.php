<?php

namespace App\Models;

use App\Constants\DB\ArchiveTables\EventArchiveDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventArchive extends Model
{
    use HasFactory;
    protected $table = EventArchiveDBConstants::TABLE;

    protected $fillable = [
        EventArchiveDBConstants::ID,
        EventArchiveDBConstants::TITLE,
        EventArchiveDBConstants::SLUG,
        EventArchiveDBConstants::LONGITUDE,
        EventArchiveDBConstants::LATITUDE,
        EventArchiveDBConstants::ADDITIONAL_AUTHOR,
        EventArchiveDBConstants::DESCRIPTION,
        EventArchiveDBConstants::SHORT_DESCRIPTION,
        EventArchiveDBConstants::MAIN_PHOTO,
        EventArchiveDBConstants::PHOTOS,
        EventArchiveDBConstants::STREET_NAME,
        EventArchiveDBConstants::BUILDING,
        EventArchiveDBConstants::PLACE_NAME,
        EventArchiveDBConstants::CORPUS,
        EventArchiveDBConstants::APARTMENT,
        EventArchiveDBConstants::PLACE_DESCRIPTION,
        EventArchiveDBConstants::START_DATE,
        EventArchiveDBConstants::START_TIME,
        EventArchiveDBConstants::FINISH_DATE,
        EventArchiveDBConstants::FINISH_TIME,
        EventArchiveDBConstants::AGE_FROM,
        EventArchiveDBConstants::AGE_TO,
        EventArchiveDBConstants::RATING,
        EventArchiveDBConstants::IS_ONLINE,
        EventArchiveDBConstants::IS_OFFLINE,
        EventArchiveDBConstants::AUTHOR_ID,
        EventArchiveDBConstants::PARENT_ID,
        EventArchiveDBConstants::COUNTRY_ID,
        EventArchiveDBConstants::REGION_ID,
        EventArchiveDBConstants::COMMUNITY_ID,
        EventArchiveDBConstants::PLACE_ID,

    ];
    public $incrementing = false;
    protected $keyType = 'string';
}
