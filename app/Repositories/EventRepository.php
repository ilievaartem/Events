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
    private const PER_PAGE = 10;

    public function getByIdWithComments(int $id): array
    {
        return Event::with([
            CommentDBConstants::TABLE => function ($query) {
                $query->paginate(self::PER_PAGE);
            }
        ])->find($id)->toArray();
    }
    public function getAllPhotosById(string $id): ?array
    {
        return Event::query()->select(['photos', 'main_photo'])->find($id)->toArray();
    }

    public function updatePhotos(string $id, string $mainPhotoPath, array $photosPaths): bool
    {
        return Event::query()->where('id', $id)->update([
            'main_photo' => $mainPhotoPath,
            'photos' => $photosPaths
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
    public function filterEvents(FilterEventDTO $filterEventDTO): ?array
    {
        return Event::query()
            ->when($filterEventDTO->getPhrase() != null && $filterEventDTO->getSearchBy() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(function (Builder $query) use ($filterEventDTO) {
                    $query
                        ->whereIn(EventDBConstants::TITLE, $filterEventDTO->getSearchBy())
                        ->orWhereIn(EventDBConstants::DESCRIPTION, $filterEventDTO->getSearchBy())
                        ->orWhereIn(EventDBConstants::PLACE_NAME, $filterEventDTO->getSearchBy())
                        ->orWhereIn(EventDBConstants::STREET_NAME, $filterEventDTO->getSearchBy());
                });
            })
            ->when($filterEventDTO->getStartDateMin() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::START_DATE, '>', $filterEventDTO->getStartDateMin());
            })
            ->when($filterEventDTO->getStartDateMax() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::START_DATE, '<', $filterEventDTO->getStartDateMax());
            })
            ->when($filterEventDTO->getFinishDateMin() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::FINISH_DATE, '>', $filterEventDTO->getFinishDateMin());
            })
            ->when($filterEventDTO->getFinishDateMax() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::FINISH_DATE, '<', $filterEventDTO->getFinishDateMax());
            })
            ->when($filterEventDTO->getRatingMin() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::RATING, '>', $filterEventDTO->getRatingMin());
            })
            ->when($filterEventDTO->getRatingMax() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::RATING, '<', $filterEventDTO->getRatingMax());
            })
            ->when($filterEventDTO->getStartTimeMin() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::START_TIME, '>', $filterEventDTO->getStartTimeMin());
            })
            ->when($filterEventDTO->getStartTimeMax() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::START_TIME, '<', $filterEventDTO->getStartTimeMax());
            })
            ->when($filterEventDTO->getFinishTimeMin() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::FINISH_TIME, '>', $filterEventDTO->getFinishTimeMin());
            })
            ->when($filterEventDTO->getFinishTimeMax() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::FINISH_TIME, '<', $filterEventDTO->getFinishTimeMax());
            })
            ->when($filterEventDTO->getLongitude() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::LONGITUDE, $filterEventDTO->getLongitude());
            })
            ->when($filterEventDTO->getLatitude() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::LONGITUDE, $filterEventDTO->getLatitude());
            })
            ->when($filterEventDTO->getAgeFrom() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::AGE_FROM, $filterEventDTO->getAgeFrom());
            })
            ->when($filterEventDTO->getAgeTo() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::AGE_TO, $filterEventDTO->getAgeTo());
            })
            ->when($filterEventDTO->getAuthorId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::AUTHOR_ID, $filterEventDTO->getAuthorId());
            })
            ->when($filterEventDTO->getParentId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::PARENT_ID, $filterEventDTO->getParentId());
            })
            ->when($filterEventDTO->getCityId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::CITY_ID, $filterEventDTO->getCityId());
            })
            ->when($filterEventDTO->getCountryId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where('country_id', '=', $filterEventDTO->getCountryId());
            })
            ->paginate(self::PER_PAGE)
            ->toArray();
    }

}
