<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\ColorDBConstants;
use App\Constants\DB\ManufacturerDBConstants;
use App\DTO\Contracts\DTOContract;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\FilterEventDTO;
use Illuminate\Database\Eloquent\Builder;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public function addTagsIds(string $id, array $tagsIds): void
    {
        Event::find($id)->tags()->sync($tagsIds);
    }
    public function addCategoriesIds(string $id, array $categoriesIds): void
    {
        Event::find($id)->categories()->sync($categoriesIds);
    }
    public function getInfoForSimilar(string $id): array
    {
        return Event::query()
            ->select([EventDBConstants::TAGS_IDS, EventDBConstants::CATEGORIES_IDS, EventDBConstants::CITY_ID])
            ->find($id)
            ->toArray();
    }
    public function getSimilarEvents(array $event): array
    {
        return Event::query()
            ->when(
                $event[EventDBConstants::CATEGORIES_IDS] != null && $event[EventDBConstants::TAGS_IDS] != null,
                function (Builder $query) use ($event) {
                    return $query->where(function (Builder $query) use ($event) {
                        $query
                            ->when($event[EventDBConstants::CATEGORIES_IDS] != null, function (Builder $query) use ($event) {
                                foreach ($event[EventDBConstants::CATEGORIES_IDS] as $category) {
                                    $query->orWhereJsonContains(EventDBConstants::CATEGORIES_IDS, $category);
                                }
                            })
                            ->when($event[EventDBConstants::CATEGORIES_IDS] != null, function (Builder $query) use ($event) {
                                foreach ($event[EventDBConstants::TAGS_IDS] as $tag) {
                                    $query->orWhereJsonContains(EventDBConstants::TAGS_IDS, $tag);
                                }
                            });
                    });
                }
            )
            ->when($event[EventDBConstants::CITY_ID] != null, function (Builder $query) use ($event) {
                return $query->where(EventDBConstants::CITY_ID, $event[EventDBConstants::CITY_ID]);
            })
            ->paginate(self::PER_PAGE)
            ->toArray();
    }

    public function checkIsEventExistByEventId(string $eventId): bool
    {
        return $this->model->where(EventDBConstants::ID, $eventId)->exists();
    }
    public function checkIsEventHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->model->where(EventDBConstants::ID, $eventId)
            ->where(EventDBConstants::AUTHOR_ID, $authorId)->exists();
    }
    public function getAuthorIdByEventId(string $eventId): ?string
    {
        return $this->model->where(EventDBConstants::ID, $eventId)->first()->author_id;
    }
    public function getTopicById(string $id): ?string
    {
        return $this->model->where(EventDBConstants::ID, $id)->first()->title;

    }
    public function getEventsByAuthorID(string $userId): array
    {
        return Event::where(EventDBConstants::AUTHOR_ID, $userId)->paginate(self::PER_PAGE)->toArray();
    }
    public function getByIdWithComments(int $id): array
    {
        return Event::with([
            CommentDBConstants::TABLE => function ($query) {
                $query->paginate(self::PER_PAGE);
            }
        ])->find($id)->toArray();
    }
    public function getEventPhotosById(string $id): ?array
    {
        return Event::query()->select([EventDBConstants::PHOTOS])->find($id)->toArray();
    }
    public function getEventMainPhotoById(string $id): ?string
    {
        return $this->model->where(EventDBConstants::ID, $id)->first()->main_photo;
    }

    public function updatePhotos(string $id, array $photosPaths): bool
    {
        return Event::query()->where(EventDBConstants::ID, $id)->update([
            EventDBConstants::PHOTOS => $photosPaths
        ]);
    }
    public function updateMainPhoto(string $id, ?string $mainPhotoPath): bool
    {
        return Event::query()->where(EventDBConstants::ID, $id)->update([
            EventDBConstants::MAIN_PHOTO => $mainPhotoPath
        ]);
    }

    public function searchEvent(?string $title, ?string $description): array
    {
        return Event::when($title != null, function ($query) use ($title) {
            return $query->where(EventDBConstants::TITLE, $title);
        })->when($description != null, function ($query) use ($description) {
            return $query->where(EventDBConstants::DESCRIPTION, $description);
        })->get()->toArray();
    }


}
