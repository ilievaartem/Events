<?php

namespace App\Services;

use App\Constants\DB\CommonDB\CommonDBConstants;
use App\Constants\DB\UserDBConstants;

class DashboardService
{
    public function __construct(
        private readonly CountryService $countryService,
        private readonly RegionService $regionService,
        private readonly EventService $eventService
    )
    {
    }

    public function index(): array
    {
        $countries = $this->countryService->getAll(UserDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);
        $regions = $this->regionService->getAll(UserDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);
        $events = $this->eventService->getAll(null, null);

        $countryEventCounts = array_fill_keys(array_column($countries, 'id'), 0);
        $regionEventCounts = array_fill_keys(array_column($regions, 'id'), 0);

        foreach ($events as $event) {
            if (isset($countryEventCounts[$event['country_id']])) {
                $countryEventCounts[$event['country_id']]++;
            }
        }

        $countryEventData = [];
        foreach ($countries as $country) {
            $countryEventData[] = [
                'name' => $country['name'],
                'count' => $countryEventCounts[$country['id']] ?? 0
            ];
        }

        foreach ($events as $event) {
            if (isset($regionEventCounts[$event['region_id']])) {
                $regionEventCounts[$event['region_id']]++;
            }
        }

        $regionEventData = [];
        foreach ($regions as $region) {
            $regionEventData[] = [
                'name' => $region['name'],
                'count' => $regionEventCounts[$region['id']] ?? 0
            ];
        }

        return [
            'countries' => $countryEventData,
            'regions' => $regionEventData,
            'events' => $events,
        ];
    }
}
