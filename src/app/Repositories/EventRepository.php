<?php

namespace App\Repositories;

use App\Constants\DB\CategoryDBConstants;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\ColorDBConstants;
use App\Constants\DB\ManufacturerDBConstants;
use App\Constants\DB\TagDBConstants;
use App\DTO\Contracts\DTOContract;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\FilterEventDTO;
use Illuminate\Database\Eloquent\Builder;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public function getEventsWithRelations(): array
    {
        return $this->model->query()
            ->with([
                TagDBConstants::TABLE => function ($query) {
                    $query->select(TagDBConstants::TABLE . '.' . TagDBConstants::ID, TagDBConstants::NAME);
                },
                CategoryDBConstants::TABLE => function ($query) {
                    $query->select(CategoryDBConstants::TABLE . '.' . CategoryDBConstants::ID, CategoryDBConstants::NAME);
                },
            ])
            ->paginate(self::PER_PAGE)->toArray();
    }
    public function getEventWithRelations(string $id): array
    {
        return $this->model->query()
            ->with([
                TagDBConstants::TABLE => function ($query) {
                    $query->select(TagDBConstants::TABLE . '.' . TagDBConstants::ID, TagDBConstants::NAME);
                },
                CategoryDBConstants::TABLE => function ($query) {
                    $query->select(CategoryDBConstants::TABLE . '.' . CategoryDBConstants::ID, CategoryDBConstants::NAME);
                },
            ])
            ->find($id)->toArray();
    }

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
        return $this->model->query()->with(
            [
                TagDBConstants::TABLE => function ($query) {
                    $query->select(TagDBConstants::TABLE . '.' . TagDBConstants::ID);
                },
                CategoryDBConstants::TABLE => function ($query) {
                    $query->select(CategoryDBConstants::TABLE . '.' . CategoryDBConstants::ID);
                },
            ]
        )

            ->select([EventDBConstants::ID, EventDBConstants::PLACE_ID])
            ->find($id)->toArray();
    }
    public function getSimilarEvents(array $events): array
    {
        return Event::query()
            ->when(
                $events['events_ids'] != null,
                function (Builder $query) use ($events) {
                    return $query->whereIn(EventDBConstants::ID, $events['events_ids']);
                }
            )
            ->when($events[EventDBConstants::PLACE_ID] != null, function (Builder $query) use ($events) {
                return $query->where(EventDBConstants::PLACE_ID, $events[EventDBConstants::PLACE_ID]);
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
