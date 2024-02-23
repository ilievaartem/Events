<?php

namespace App\Models;

use App\Constants\DB\EventDBConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Malhal\Geographical\Geographical;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Event extends Model
{
    use HasFactory;
    use Geographical;
    use Searchable;


    protected $fillable = [
        EventDBConstants::TITLE,
        EventDBConstants::SLUG,
        EventDBConstants::LONGITUDE,
        EventDBConstants::LATITUDE,
        EventDBConstants::ADDITIONAL_AUTHOR,
        EventDBConstants::DESCRIPTION,
        EventDBConstants::SHORT_DESCRIPTION,
        EventDBConstants::MAIN_PHOTO,
        EventDBConstants::PHOTOS,
        EventDBConstants::STREET_NAME,
        EventDBConstants::BUILDING,
        EventDBConstants::PLACE_NAME,
        EventDBConstants::CORPUS,
        EventDBConstants::APARTMENT,
        EventDBConstants::PLACE_DESCRIPTION,
        EventDBConstants::START_DATE,
        EventDBConstants::START_TIME,
        EventDBConstants::FINISH_DATE,
        EventDBConstants::FINISH_TIME,
        EventDBConstants::AGE_FROM,
        EventDBConstants::AGE_TO,
        EventDBConstants::CATEGORIES_IDS,
        EventDBConstants::TAGS_IDS,
        EventDBConstants::APPLIERS,
        EventDBConstants::INTERESTARS,
        EventDBConstants::RATING,
        EventDBConstants::IS_ONLINE,
        EventDBConstants::IS_OFFLINE,
        EventDBConstants::AUTHOR_ID,
        EventDBConstants::PARENT_ID,
        EventDBConstants::CITY_ID,
        EventDBConstants::COUNTRY_ID,
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        EventDBConstants::ID => 'string',
    ];
    public function toSearchableArray()
    {
        return [
            EventDBConstants::TITLE => $this->title,
            EventDBConstants::LONGITUDE => $this->longitude,
            EventDBConstants::LATITUDE => $this->latitude,
            EventDBConstants::DESCRIPTION => $this->description,
            EventDBConstants::STREET_NAME => $this->street_name,
            EventDBConstants::PLACE_NAME => $this->place_name,
            EventDBConstants::START_DATE => $this->start_date,
            EventDBConstants::START_TIME => $this->start_time,
            EventDBConstants::FINISH_DATE => $this->finish_date,
            EventDBConstants::FINISH_TIME => $this->finish_time,
            EventDBConstants::AGE_FROM => $this->age_from,
            EventDBConstants::AGE_TO => $this->age_to,
            EventDBConstants::CATEGORIES_IDS => $this->categories_ids,
            EventDBConstants::TAGS_IDS => $this->tags_ids,
            EventDBConstants::RATING => $this->rating,
            EventDBConstants::AUTHOR_ID => $this->author_id,
            EventDBConstants::PARENT_ID => $this->parent_id,
            EventDBConstants::CITY_ID => $this->city_id,
            EventDBConstants::COUNTRY_ID => $this->country_id,
        ];
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $matches = [];
            $asciiRepresentation = $model->getAsciiRepresentation($model->title);
            $lastSlugByTemplate = $model->getLatestSlugByTemplate($asciiRepresentation);
            $model->slug = $asciiRepresentation;
            if ($lastSlugByTemplate != null) {
                $model->slug = ($model->checkIsNumberExistInSlug($lastSlugByTemplate, $matches)
                    ? $model->updateSlugNumber($asciiRepresentation, $matches)
                    : $model->setSlugNumber($asciiRepresentation));
            }
            $model->{$model->getKeyName()} = (string) Str::orderedUuid();
        });
        static::updating(function ($model) {
            $this->$model->searchable();
        });
    }

    public function checkIsNumberExistInSlug(string $lastSlugByTemplate, array &$matches): bool|int
    {
        return preg_match('/(\d+)/', $lastSlugByTemplate, $matches);

    }
    public function updateSlugNumber(string $asciiRepresentation, $matches): string
    {
        return $asciiRepresentation . '_' . (int) ++$matches[0];
    }
    public function setSlugNumber(string $asciiRepresentation): string
    {
        return $asciiRepresentation . '_1';
    }
    public function getAsciiRepresentation(string $eventTitle): string
    {
        return Str::ascii($eventTitle);
    }
    public function getLatestSlugByTemplate(string $slugToFind): ?string
    {

        $event = $this->query()
            ->select(EventDBConstants::SLUG)
            ->where(EventDBConstants::SLUG, 'like', $slugToFind . '%')
            ->orderBy(EventDBConstants::SLUG, 'desc')->first();

        return ($event === null) ? null : $event->slug;

    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class);
    }
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    public function interesters(): HasMany
    {
        return $this->hasMany(Interester::class);
    }
    public function appliers(): HasMany
    {
        return $this->hasMany(Applier::class);
    }
}
