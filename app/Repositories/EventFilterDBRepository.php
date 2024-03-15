<?php

namespace App\Repositories;

use App\Constants\DB\EventDBConstants;
use App\DTO\Event\FilterEventDTO;
use App\Models\Event;
use App\Repositories\Interfaces\EventFilterRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class EventFilterDBRepository implements EventFilterRepositoryInterface
{
    protected $model;
    private const PER_PAGE = 10;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function filterEvents(FilterEventDTO $filterEventDTO): ?array
    {
        return Event::query()

            ->when($filterEventDTO->getPhrase() != null && $filterEventDTO->getSearchBy() == null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(function (Builder $query) use ($filterEventDTO) {
                    $query
                        ->where(EventDBConstants::TITLE, 'like', '%' . $filterEventDTO->getPhrase() . '%')
                        ->orWhere(EventDBConstants::DESCRIPTION, 'like', '%' . $filterEventDTO->getPhrase() . '%')
                        ->orWhere(EventDBConstants::PLACE_NAME, 'like', '%' . $filterEventDTO->getPhrase() . '%')
                        ->orWhere(EventDBConstants::STREET_NAME, 'like', '%' . $filterEventDTO->getPhrase() . '%');
                });
            })
            ->when($filterEventDTO->getPhrase() != null && $filterEventDTO->getSearchBy() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(function (Builder $query) use ($filterEventDTO) {
                    $query
                        ->when(array_key_exists(EventDBConstants::TITLE, $filterEventDTO->getSearchBy()), function (Builder $query) use ($filterEventDTO) {
                            $query->where(EventDBConstants::TITLE, 'like', '%' . $filterEventDTO->getPhrase() . '%');
                        })
                        ->when(array_key_exists(EventDBConstants::DESCRIPTION, $filterEventDTO->getSearchBy()), function (Builder $query) use ($filterEventDTO) {
                            $query->orWhere(EventDBConstants::DESCRIPTION, 'like', '%' . $filterEventDTO->getPhrase() . '%');
                        })
                        ->when(array_key_exists(EventDBConstants::PLACE_NAME, $filterEventDTO->getSearchBy()), function (Builder $query) use ($filterEventDTO) {
                            $query->orWhere(EventDBConstants::PLACE_NAME, 'like', '%' . $filterEventDTO->getPhrase() . '%');
                        })
                        ->when(array_key_exists(EventDBConstants::STREET_NAME, $filterEventDTO->getSearchBy()), function (Builder $query) use ($filterEventDTO) {
                            $query->orWhere(EventDBConstants::STREET_NAME, 'like', '%' . $filterEventDTO->getPhrase() . '%');
                        });
                });
            })
            ->when($filterEventDTO->getLongitude() !== null
                && $filterEventDTO->getLatitude() !== null
                && $filterEventDTO->getGeoRadius() !== null, function (Builder $query) use ($filterEventDTO) {
                    return
                        $query->geofence(
                            $filterEventDTO->getLatitude(),
                            $filterEventDTO->getLongitude(),
                            0,
                            $filterEventDTO->getGeoRadius()
                        );
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
            ->when($filterEventDTO->getAge() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::AGE, $filterEventDTO->getAge());
            })
            ->when($filterEventDTO->getAuthorId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::AUTHOR_ID, $filterEventDTO->getAuthorId());
            })
            ->when($filterEventDTO->getParentId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::PARENT_ID, $filterEventDTO->getParentId());
            })
            ->when($filterEventDTO->getCountryId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::COUNTRY_ID, $filterEventDTO->getCountryId());
            })
            ->when($filterEventDTO->getRegionId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::REGION_ID, $filterEventDTO->getRegionId());
            })
            ->when($filterEventDTO->getCommunityId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::COMMUNITY_ID, $filterEventDTO->getCommunityId());
            })
            ->when($filterEventDTO->getPlaceId() != null, function (Builder $query) use ($filterEventDTO) {
                return $query->where(EventDBConstants::PLACE_ID, $filterEventDTO->getPlaceId());
            })
            ->paginate(self::PER_PAGE)
            ->toArray();
    }
}
