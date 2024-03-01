<?php

namespace App\Repositories;

use App\Constants\DB\EventDBConstants;
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
        // return Event::index('events')->search(
        //     '',
        //     [
        //         'filter' => '_geoRadius(45.472735, 9.184019, 2000)'
        //     ]
        // )
        //     ->paginate(self::PER_PAGE)
        //     ->toArray();
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
                    empty($options['filter'])
                        ? $options['filter'] = '_geoRadius(' . $filterEventDTO->getLatitude()
                        . ', ' . $filterEventDTO->getLongitude() . ', ' . $filterEventDTO->getGeoRadius() . ')'
                        : $options['filter'] .= ' AND ' . '_geoRadius(' . $filterEventDTO->getLatitude()
                        . ', ' . $filterEventDTO->getLongitude() . ', ' . $filterEventDTO->getGeoRadius() . ')';


                }

                if (!empty($filterEventDTO->getSearchBy())) {
                    if (array_key_exists(EventDBConstants::TITLE, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventDBConstants::TITLE;

                    }
                    if (array_key_exists(EventDBConstants::DESCRIPTION, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventDBConstants::DESCRIPTION;

                    }
                    if (array_key_exists(EventDBConstants::PLACE_NAME, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventDBConstants::PLACE_NAME;

                    }
                    if (array_key_exists(EventDBConstants::STREET_NAME, $filterEventDTO->getSearchBy())) {
                        $options['attributesToSearchOn'][] = EventDBConstants::STREET_NAME;

                    }
                }

                if ($filterEventDTO->getStartTimeMinUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::START_TIME . '>' . $filterEventDTO->getStartTimeMinUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::START_TIME . '>' . $filterEventDTO->getStartTimeMinUnix();
                }
                if ($filterEventDTO->getStartTimeMaxUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::START_TIME . '<' . $filterEventDTO->getStartTimeMaxUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::START_TIME . '<' . $filterEventDTO->getStartTimeMaxUnix();
                }
                if ($filterEventDTO->getStartDateMinUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::START_DATE . '>' . $filterEventDTO->getStartDateMinUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::START_DATE . '>' . $filterEventDTO->getStartDateMinUnix();
                }
                if ($filterEventDTO->getStartDateMaxUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::START_DATE . '<' . $filterEventDTO->getStartDateMaxUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::START_DATE . '<' . $filterEventDTO->getStartDateMaxUnix();
                }
                if ($filterEventDTO->getFinishDateMinUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::FINISH_DATE . '>' . $filterEventDTO->getFinishDateMinUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::FINISH_DATE . '>' . $filterEventDTO->getFinishDateMinUnix();
                }
                if ($filterEventDTO->getFinishDateMaxUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::FINISH_DATE . '<' . $filterEventDTO->getFinishDateMaxUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::FINISH_DATE . '<' . $filterEventDTO->getFinishDateMaxUnix();
                }
                if ($filterEventDTO->getFinishTimeMinUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::FINISH_TIME . '>' . $filterEventDTO->getFinishTimeMinUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::FINISH_TIME . '>' . $filterEventDTO->getFinishTimeMinUnix();
                }
                if ($filterEventDTO->getFinishTimeMaxUnix() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::FINISH_TIME . '<' . $filterEventDTO->getFinishTimeMaxUnix()
                        : $options['filter'] .= ' AND ' . EventDBConstants::FINISH_TIME . '<' . $filterEventDTO->getFinishTimeMaxUnix();
                }
                if ($filterEventDTO->getRatingMin() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::RATING . '>' . $filterEventDTO->getRatingMin()
                        : $options['filter'] .= ' AND ' . EventDBConstants::RATING . '>' . $filterEventDTO->getRatingMin();
                }
                if ($filterEventDTO->getRatingMax() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::RATING . '<' . $filterEventDTO->getRatingMax()
                        : $options['filter'] .= ' AND ' . EventDBConstants::RATING . '<' . $filterEventDTO->getRatingMax();
                }


                if ($filterEventDTO->getAgeFrom() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::AGE_FROM . '>=' . $filterEventDTO->getAgeFrom()
                        : $options['filter'] .= ' AND ' . EventDBConstants::AGE_FROM . '>=' . $filterEventDTO->getAgeFrom();
                }
                if ($filterEventDTO->getAgeTo() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::AGE_TO . '<=' . $filterEventDTO->getAgeTo()
                        : $options['filter'] .= ' AND ' . EventDBConstants::AGE_TO . '<=' . $filterEventDTO->getAgeTo();
                }
                if ($filterEventDTO->getAuthorId() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::AUTHOR_ID . '=' . $filterEventDTO->getAuthorId()
                        : $options['filter'] .= ' AND ' . EventDBConstants::AUTHOR_ID . '=' . $filterEventDTO->getAuthorId();
                }
                if ($filterEventDTO->getParentId() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::PARENT_ID . '=' . $filterEventDTO->getParentId()
                        : $options['filter'] .= ' AND ' . EventDBConstants::PARENT_ID . '=' . $filterEventDTO->getParentId();
                }
                if ($filterEventDTO->getCityId() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::CITY_ID . '=' . $filterEventDTO->getCityId()
                        : $options['filter'] .= ' AND ' . EventDBConstants::CITY_ID . '=' . $filterEventDTO->getCityId();
                }
                if ($filterEventDTO->getCountryId() != null) {
                    empty($options['filter'])
                        ? $options['filter'] = EventDBConstants::COUNTRY_ID . '=' . $filterEventDTO->getCountryId()
                        : $options['filter'] .= ' AND ' . EventDBConstants::COUNTRY_ID . '=' . $filterEventDTO->getCountryId();
                }

                return $meiliSearch->search($query, $options);
            }
        )
            ->paginate(self::PER_PAGE)
            ->toArray();







    }
}
