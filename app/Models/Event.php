<?php

namespace App\Models;

use App\Constants\DB\EventDBConstants;
use App\Constants\Request\EventRequestConstants;
use App\Constants\Search\EventSearchConstants;
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
        EventDBConstants::AGE,
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
    protected $hidden = ['pivot'];
    protected $casts = [
        EventDBConstants::ID => 'string',
        EventDBConstants::PHOTOS => 'array',
        EventDBConstants::CATEGORIES_IDS => 'array',
        EventDBConstants::TAGS_IDS => 'array',

    ];
    public function toSearchableArray()
    {
        return [
            EventSearchConstants::TITLE => $this->title,
            EventSearchConstants::_GEO => [
                EventSearchConstants::LATITUDE => (float) $this->latitude,
                EventSearchConstants::LONGITUDE => (float) $this->longitude,
            ],
            EventSearchConstants::DESCRIPTION => $this->description,
            EventSearchConstants::STREET_NAME => $this->street_name,
            EventSearchConstants::PLACE_NAME => $this->place_name,
            EventSearchConstants::START_DATE => strtotime($this->start_date),
            EventSearchConstants::START_TIME => strtotime($this->start_time),
            EventSearchConstants::FINISH_DATE => strtotime($this->finish_date),
            EventSearchConstants::FINISH_TIME => strtotime($this->finish_time),
            EventSearchConstants::AGE => $this->age,
            EventSearchConstants::CATEGORIES_IDS => $this->categories_ids,
            EventSearchConstants::TAGS_IDS => $this->tags_ids,
            EventSearchConstants::RATING => $this->rating,
            EventSearchConstants::AUTHOR_ID => $this->author_id,
            EventSearchConstants::PARENT_ID => $this->parent_id,
            EventSearchConstants::CITY_ID => $this->city_id,
            EventSearchConstants::COUNTRY_ID => $this->country_id,
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

        return($event === null) ? null : $event->slug;

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
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, EventDBConstants::ID);
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
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
