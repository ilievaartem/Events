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
            ->when($filterEventDTO->getPhrase() != null && $filterEventDTO->getSearchBy() != null, function (Builder $query) use ($filterEventDTO) {
                dd($filterEventDTO->getSearchBy()[EventDBConstants::TITLE]);
                return $query->where(function (Builder $query) use ($filterEventDTO) {
                    $query
                        ->whereIn(EventDBConstants::TITLE, $filterEventDTO->getSearchBy()[EventDBConstants::TITLE])
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
