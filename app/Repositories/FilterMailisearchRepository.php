<?php

namespace App\Repositories;

use App\Constants\Search\EventSearchConstants;
use App\DTO\Event\FilterEventDTO;
use App\Models\Event;
use App\Repositories\Interfaces\EventFilterRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Meilisearch\Endpoints\Indexes;

class FilterMailisearchRepository implements EventFilterRepositoryInterface
{
    protected $model;
    private const PER_PAGE = 10;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }
    public function filterEvents(FilterEventDTO $filterEventDTO): ?array
    {
        return Event::search(

            $filterEventDTO->getPhrase() == null
            ? ''
            : $filterEventDTO->getPhrase(),

            function (Indexes $meiliSearch, string $query, array $options) use ($filterEventDTO) {

                if (
                    $filterEventDTO->getLongitude() !== null
                    && $filterEventDTO->getLatitude() !== null
                    && $filterEventDTO->getGeoRadius() !== null
                ) {
                    empty ($options['filter'])
                        ? $options['filter'] = '_geoRadius(' . $filterEventDTO->getLatitude()
                        . ', ' . $filterEventDTO->getLongitude() . ', ' . $filterEventDTO->getGeoRadius() . ')'
                        : $options['filter'] .= ' AND ' . '_geoRadius(' . $filterEventDTO->getLatitude()
                        . ', ' . $filterEventDTO->getLongitude() . ', ' . $filterEventDTO->getGeoRadius() . ')';


                }

                if (!empty ($filterEventDTO->getSearchBy())) {
                    if (array_key_exists(EventSearchConstants::TITLE, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventSearchConstants::TITLE;

                    }
                    if (array_key_exists(EventSearchConstants::DESCRIPTION, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventSearchConstants::DESCRIPTION;

                    }
                    if (array_key_exists(EventSearchConstants::PLACE_NAME, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventSearchConstants::PLACE_NAME;

                    }
                    if (array_key_exists(EventSearchConstants::STREET_NAME, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventSearchConstants::STREET_NAME;

                    }
                }

                if ($filterEventDTO->getStartTimeMinUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::START_TIME . '>' . $filterEventDTO->getStartTimeMinUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::START_TIME . '>' . $filterEventDTO->getStartTimeMinUnix();
                }
                if ($filterEventDTO->getStartTimeMaxUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::START_TIME . '<' . $filterEventDTO->getStartTimeMaxUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::START_TIME . '<' . $filterEventDTO->getStartTimeMaxUnix();
                }
                if ($filterEventDTO->getStartDateMinUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::START_DATE . '>' . $filterEventDTO->getStartDateMinUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::START_DATE . '>' . $filterEventDTO->getStartDateMinUnix();
                }
                if ($filterEventDTO->getStartDateMaxUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::START_DATE . '<' . $filterEventDTO->getStartDateMaxUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::START_DATE . '<' . $filterEventDTO->getStartDateMaxUnix();
                }
                if ($filterEventDTO->getFinishDateMinUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::FINISH_DATE . '>' . $filterEventDTO->getFinishDateMinUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::FINISH_DATE . '>' . $filterEventDTO->getFinishDateMinUnix();
                }
                if ($filterEventDTO->getFinishDateMaxUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::FINISH_DATE . '<' . $filterEventDTO->getFinishDateMaxUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::FINISH_DATE . '<' . $filterEventDTO->getFinishDateMaxUnix();
                }
                if ($filterEventDTO->getFinishTimeMinUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::FINISH_TIME . '>' . $filterEventDTO->getFinishTimeMinUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::FINISH_TIME . '>' . $filterEventDTO->getFinishTimeMinUnix();
                }
                if ($filterEventDTO->getFinishTimeMaxUnix() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::FINISH_TIME . '<' . $filterEventDTO->getFinishTimeMaxUnix()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::FINISH_TIME . '<' . $filterEventDTO->getFinishTimeMaxUnix();
                }
                if ($filterEventDTO->getRatingMin() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::RATING . '>' . $filterEventDTO->getRatingMin()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::RATING . '>' . $filterEventDTO->getRatingMin();
                }
                if ($filterEventDTO->getRatingMax() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::RATING . '<' . $filterEventDTO->getRatingMax()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::RATING . '<' . $filterEventDTO->getRatingMax();
                }


                if ($filterEventDTO->getAge() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::AGE . '=' . $filterEventDTO->getAge()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::AGE . '=' . $filterEventDTO->getAge();
                }

                if ($filterEventDTO->getAuthorId() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::AUTHOR_ID . '=' . $filterEventDTO->getAuthorId()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::AUTHOR_ID . '=' . $filterEventDTO->getAuthorId();
                }
                if ($filterEventDTO->getParentId() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::PARENT_ID . '=' . $filterEventDTO->getParentId()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::PARENT_ID . '=' . $filterEventDTO->getParentId();
                }
                if ($filterEventDTO->getCountryId() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::COUNTRY_ID . '=' . $filterEventDTO->getCountryId()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::COUNTRY_ID . '=' . $filterEventDTO->getCountryId();
                }
                if ($filterEventDTO->getRegionId() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::REGION_ID . '=' . $filterEventDTO->getRegionId()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::REGION_ID . '=' . $filterEventDTO->getRegionId();
                }
                if ($filterEventDTO->getCommunityId() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::COMMUNITY_ID . '=' . $filterEventDTO->getCommunityId()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::COMMUNITY_ID . '=' . $filterEventDTO->getCommunityId();
                }
                if ($filterEventDTO->getPlaceId() != null) {
                    empty ($options['filter'])
                        ? $options['filter'] = EventSearchConstants::PLACE_ID . '=' . $filterEventDTO->getPlaceId()
                        : $options['filter'] .= ' AND ' . EventSearchConstants::PLACE_ID . '=' . $filterEventDTO->getPlaceId();
                }

                return $meiliSearch->search($query, $options);
            }
        )
            ->paginate(self::PER_PAGE)
            ->toArray();







    }
}
