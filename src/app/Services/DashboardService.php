<?php

namespace App\Services;

use App\Constants\Content\ComplaintsConstant;
use App\Constants\DB\CommonDB\CommonDBConstants;
use App\Constants\DB\UserDBConstants;

class DashboardService
{
    public function __construct(
        private readonly CountryService $countryService,
        private readonly RegionService $regionService,
        private readonly EventService $eventService,
        private readonly ComplaintService $complaintService,
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
        $regionsByCountry = [];
        $ageGroups = [];

        foreach ($events as $event) {
            if (isset($countryEventCounts[$event['country_id']])) {
                $countryEventCounts[$event['country_id']]++;
            }
            if (isset($regionEventCounts[$event['region_id']])) {
                $regionEventCounts[$event['region_id']]++;
            }

            if (isset($event['age'])){
                $ageGroup = $event['age'];
                if (!isset($ageGroups[$ageGroup])) {
                    $ageGroups[$ageGroup] = 0;
                }
                $ageGroups[$ageGroup]++;
            }
        }

        foreach ($regions as $region) {
            $regionsByCountry[$region['country_id']][] = [
                'name' => $region['name'],
                'count' => $regionEventCounts[$region['id']] ?? 0
            ];
        }

        $countryEventData = [];
        foreach ($countries as $country) {
            $countryEventData[] = [
                'id' => $country['id'],
                'name' => $country['name'],
                'count' => $countryEventCounts[$country['id']] ?? 0
            ];
        }

        $ageGroupData = [];
        foreach ($ageGroups as $ageGroup => $count) {
            $ageGroupData[] = [
                'label' => $ageGroup,
                'count' => $count
            ];
        }

        return [
            'countries' => $countryEventData,
            'regions' => $regionsByCountry,
            'events' => [
                'list' => $events,
                'ageGroups' => $ageGroupData
            ]
        ];
    }
    public function getComplaintsStatistics(): array
    {
        $complaints = $this->complaintService->getAll(null, null);

        $notResolved = array_fill(0, 12, 0);
        $resolvedPositive = array_fill(0, 12, 0);
        $resolvedNegative = array_fill(0, 12, 0);

        foreach ($complaints as $complaint) {
            $month = date('n', strtotime($complaint['created_at'])) - 1;
            if (is_null($complaint['resolved_at'])) {
                $notResolved[$month]++;
            } elseif ($complaint['resolve_message'] === ComplaintsConstant::RESOLVE_MESSAGE_APPLIED) {
                $resolvedPositive[$month]++;
            } elseif ($complaint['resolve_message'] === ComplaintsConstant::RESOLVE_MESSAGE_DECLINED) {
                $resolvedNegative[$month]++;
            }
        }

        return [
            'notResolved' => $notResolved,
            'resolvedPositive' => $resolvedPositive,
            'resolvedNegative' => $resolvedNegative,
        ];
    }

}
