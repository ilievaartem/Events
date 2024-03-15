<?php

namespace Database\Seeders;

use App\Constants\DB\CommunityDBConstants;
use App\Constants\DB\PlaceDBConstants;
use App\Constants\DB\RegionDBConstants;
use App\Models\Community;
use App\Models\Place;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = File::get('app/DataProvider/Geo/CitiesAndVillages.json');
        $json = json_decode(json: $contents, associative: true);
        $regionsForDb = [];
        $regions = [];
        foreach ($this->generatorRegionFunction($json) as $value) {
            $regions[] = $value;
        }
        $cum = array_unique($regions);
        foreach ($cum as $value) {
            $regionsForDb[] = [
                RegionDBConstants::NAME => $value,
                RegionDBConstants::COUNTRY_ID => 5
            ];
        }
        Region::insert($regionsForDb);
        $formatRegions = [];
        $regionsFromDB = Region::query()->select([RegionDBConstants::ID, RegionDBConstants::NAME])->get()->toArray();

        foreach ($regionsFromDB as $region) {
            $formatRegions[$region[RegionDBConstants::NAME]] = $region[RegionDBConstants::ID];
        }
        $communities = [];
        foreach ($this->generatorCommunityFunction($json) as $value) {
            $currentRegionId = $formatRegions[$value['regionName']];
            $communities[$value['name'] . $value['regionName']] = [
                CommunityDBConstants::NAME => $value['name'],
                CommunityDBConstants::REGION_ID => $currentRegionId
            ];
        }
        Community::insert($communities);
        $formatCommunities = [];
        $communitiesFromDB = Community::query()->select([CommunityDBConstants::ID, CommunityDBConstants::NAME])->get()->toArray();

        foreach ($communitiesFromDB as $community) {
            $formatCommunities[$community[CommunityDBConstants::NAME]] = $community[CommunityDBConstants::ID];
        }
        foreach ($this->generatorPlaceFunction($json) as $value) {
            $currentCommunityId = $formatCommunities[$value['communityName']];
            $places[$value['name'] . $value['communityName']] = [
                PlaceDBConstants::NAME => $value['name'],
                PlaceDBConstants::TYPE => $value['type'],
                PlaceDBConstants::COMMUNITY_ID => $currentCommunityId
            ];
        }
        $res = array_chunk($places, 1000);
        foreach ($res as $place) {
            Place::insert($place);
        }

    }
    public function generatorRegionFunction($json)
    {
        foreach ($json as $value) {
            yield $value['region'];
        }
    }
    public function generatorCommunityFunction($json)
    {
        foreach ($json as $value) {
            yield [
                'name' => $value['community'],
                'regionName' => $value['region'],
            ];
        }
    }
    public function generatorPlaceFunction($json)
    {
        foreach ($json as $value) {
            yield [
                'name' => $value['object_name'],
                'type' => $value['object_category'],
                'communityName' => $value['community'],
            ];
        }
    }
}
