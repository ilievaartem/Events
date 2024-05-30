<?php

namespace App\Repositories;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\DB\ColorDBConstants;
use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\ManufacturerDBConstants;
use App\Constants\DB\TagDBConstants;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
//                'users'=> function ($query) {
//                    $query->select('users'. '.' . UserDBConstants::ID, UserDBConstants::NAME);
//                },
//                CountryDBConstants::TABLE => function ($query) {
//                    $query->select(CountryDBConstants::TABLE . '.' . CountryDBConstants::ID, CountryDBConstants::NAME);
//                },
//                RegionDBConstants::TABLE => function ($query) {
//                    $query->select(RegionDBConstants::TABLE . '.' . RegionDBConstants::ID, RegionDBConstants::NAME);
//                },
//                CommunityDBConstants::TABLE => function ($query) {
//                    $query->select(CommunityDBConstants::TABLE . '.' . CommunityDBConstants::ID, CommunityDBConstants::NAME);
//                },
//                PlaceDBConstants::TABLE => function ($query) {
//                    $query->select(PlaceDBConstants::TABLE . '.' . PlaceDBConstants::ID, PlaceDBConstants::NAME);
//                },
//                "author_id" => "018ee631-3678-712d-a505-f3ddfc77bf58"
//      "parent_id" => null
//      "country_id" => 5
//      "region_id" => 5
//      "community_id" => 146
//      "place_id" => 5955
            ])
            ->paginate(self::PER_PAGE)->toArray();
    }

    /**
     * @param string $id
     * @return array
     */
    public function getEventWithOtherData(string $id): array
    {
        return $this->model->query()
            ->with('author', 'country', 'region', 'community', 'place', 'tags', 'categories')->find($id)->toArray();
    }

    /**
     * @param string $id
     * @param array $tagsIds
     * @return void
     */
    public function addTagsIds(string $id, array $tagsIds): void
    {
        Event::find($id)->tags()->sync($tagsIds);
    }

    /**
     * @param string $id
     * @param array $categoriesIds
     * @return void
     */
    public function addCategoriesIds(string $id, array $categoriesIds): void
    {
        Event::find($id)->categories()->sync($categoriesIds);
    }

    /**
     * @param string $id
     * @return array
     */
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

    /**
     * @param array $events
     * @return array
     */
    public function getSimilarEvents(array $events): array
    {
        return $this->model->query()
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

    /**
     * @param string $eventId
     * @return bool
     */
    public function checkIsEventExistByEventId(string $eventId): bool
    {
        return $this->model->query()->where(EventDBConstants::ID, $eventId)->exists();
    }

    /**
     * @param string $eventId
     * @param string $authorId
     * @return bool
     */
    public function checkIsEventHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->model->query()->where(EventDBConstants::ID, $eventId)
            ->where(EventDBConstants::AUTHOR_ID, $authorId)->exists();
    }

    /**
     * @param string $eventId
     * @return string|null
     */
    public function getAuthorIdByEventId(string $eventId): ?string
    {
        return $this->model->query()->where(EventDBConstants::ID, $eventId)->first()->author_id;
    }

    /**
     * @param string $id
     * @return string|null
     */
    public function getTopicById(string $id): ?string
    {
        return $this->model->query()->where(EventDBConstants::ID, $id)->first()->title;

    }

    /**
     * @param string $userId
     * @return array
     */
    public function getEventsByAuthorID(string $userId): array
    {
        return $this->model->query()->where(EventDBConstants::AUTHOR_ID, $userId)->paginate(self::PER_PAGE)->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getByIdWithComments(int $id): array
    {
        return $this->model->query()->with([
            CommentDBConstants::TABLE => function ($query) {
                $query->paginate(self::PER_PAGE);
            }
        ])->find($id)->toArray();
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getEventPhotosById(string $id): ?array
    {
        return $this->model->query()->query()->select([EventDBConstants::PHOTOS])->find($id)->toArray();
    }

    /**
     * @param string $id
     * @return string|null
     */
    public function getEventMainPhotoById(string $id): ?string
    {
        return $this->model->query()->where(EventDBConstants::ID, $id)->first()->main_photo;
    }

    /**
     *
     * @param string $id
     * @param array $photosPaths
     * @return bool
     */
    public function updatePhotos(string $id, array $photosPaths): bool
    {
        return $this->model->query()->where(EventDBConstants::ID, $id)->update([
            EventDBConstants::PHOTOS => $photosPaths
        ]);
    }

    /**
     * @param string $id
     * @param string|null $mainPhotoPath
     * @return bool
     */
    public function updateMainPhoto(string $id, ?string $mainPhotoPath): bool
    {
        return $this->model->query()->where(EventDBConstants::ID, $id)->update([
            EventDBConstants::MAIN_PHOTO => $mainPhotoPath
        ]);
    }

    /**
     * @param string|null $title
     * @param string|null $description
     * @return array
     */
    public function searchEvent(?string $title, ?string $description): array
    {
        return $this->model->query()->when($title != null, function ($query) use ($title) {
            return $query->where(EventDBConstants::TITLE, $title);
        })->when($description != null, function ($query) use ($description) {
            return $query->where(EventDBConstants::DESCRIPTION, $description);
        })->get()->toArray();
    }

    /**
     * @param int $year
     * @param array $months
     * @return array
     */
    public function getEventCountsByYearAndMonths(int $year, array $months): array
    {
        return $this->model->query()
            ->whereYear('created_at', '=', $year)
            ->whereIn(DB::raw('EXTRACT(MONTH FROM created_at)'), $months)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
            })
            ->map(function ($events) {
                return $events->count();
            })
            ->toArray();
    }
}
