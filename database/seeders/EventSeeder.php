<?php

namespace Database\Seeders;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\DB\CityDBConstants;
use App\Constants\DB\CommunityDBConstants;
use App\Constants\DB\CountryDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\PlaceDBConstants;
use App\Constants\DB\RegionDBConstants;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Constants\DB\TagDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\City;
use App\Models\Country;
use App\Models\Event;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Nette\Utils\Random;
use Ramsey\Uuid\Uuid;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run(): void
    {
        $allAuthors = User::query()->select(UserDBConstants::ID)->get()->pluck(UserDBConstants::ID)->toArray();

        $ageTypes = [EventDBConstants::AGE_KIDS, EventDBConstants::AGE_TEENS, EventDBConstants::AGE_ANY, EventDBConstants::AGE_ADULT];
        $geo = Country::query()
            ->join(
                RegionDBConstants::TABLE,
                CountryDBConstants::TABLE . '.' . CountryDBConstants::ID,
                '=',
                RegionDBConstants::TABLE . '.' . RegionDBConstants::COUNTRY_ID
            )
            ->join(
                CommunityDBConstants::TABLE,
                RegionDBConstants::TABLE . '.' . RegionDBConstants::ID,
                '=',
                CommunityDBConstants::TABLE . '.' . CommunityDBConstants::REGION_ID
            )
            ->join(
                PlaceDBConstants::TABLE,
                CommunityDBConstants::TABLE . '.' . CommunityDBConstants::ID,
                '=',
                PlaceDBConstants::TABLE . '.' . PlaceDBConstants::COMMUNITY_ID
            )
            ->select(
                CountryDBConstants::TABLE . '.' . CountryDBConstants::ID . ' as ' . RegionDBConstants::COUNTRY_ID,
                RegionDBConstants::TABLE . '.' . RegionDBConstants::ID . ' as ' . CommunityDBConstants::REGION_ID,
                CommunityDBConstants::TABLE . '.' . CommunityDBConstants::ID . ' as ' . PlaceDBConstants::COMMUNITY_ID,
                PlaceDBConstants::TABLE . '.' . PlaceDBConstants::ID . ' as place_id'
            )
            ->get()->toArray();
        $events = [];
        for ($i = 0; $i < 10000; $i++) {
            $authors = Arr::random($allAuthors);
            $ageType = Arr::random($ageTypes);
            $currentGeo = Arr::random($geo);
            $events[] = [
                EventDBConstants::ID => Uuid::uuid7()->toString(),
                EventDBConstants::TITLE => fake()->title(),
                EventDBConstants::SLUG => fake()->unique()->slug(),
                EventDBConstants::LONGITUDE => fake()->longitude(),
                EventDBConstants::LATITUDE => fake()->latitude(),
                EventDBConstants::ADDITIONAL_AUTHOR => null,
                EventDBConstants::DESCRIPTION => fake()->realText(200),
                EventDBConstants::SHORT_DESCRIPTION => fake()->sentence(),
                EventDBConstants::MAIN_PHOTO => null,
                EventDBConstants::PHOTOS => null,
                EventDBConstants::STREET_NAME => fake()->streetName(),
                EventDBConstants::BUILDING => null,
                EventDBConstants::PLACE_NAME => null,
                EventDBConstants::CORPUS => null,
                EventDBConstants::APARTMENT => null,
                EventDBConstants::PLACE_DESCRIPTION => fake()->text(),
                EventDBConstants::START_DATE => fake()->date(),
                EventDBConstants::START_TIME => fake()->time(),
                EventDBConstants::FINISH_DATE => fake()->date(),
                EventDBConstants::FINISH_TIME => fake()->time(),
                EventDBConstants::AGE => $ageType,
                EventDBConstants::RATING => null,
                EventDBConstants::IS_ONLINE => null,
                EventDBConstants::IS_OFFLINE => null,
                EventDBConstants::AUTHOR_ID => $authors,
                EventDBConstants::PARENT_ID => null,
                EventDBConstants::COUNTRY_ID => $currentGeo[RegionDBConstants::COUNTRY_ID],
                EventDBConstants::REGION_ID => $currentGeo[CommunityDBConstants::REGION_ID],
                EventDBConstants::COMMUNITY_ID => $currentGeo[PlaceDBConstants::COMMUNITY_ID],
                EventDBConstants::PLACE_ID => $currentGeo['place_id'],

            ];
        }
        $res = array_chunk($events, 1000);
        foreach ($res as $event) {
            Event::insert($event);
        }


    }
}
