<?php

namespace Database\Seeders;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\DB\CityDBConstants;
use App\Constants\DB\CountryDBConstants;
use App\Constants\DB\EventDBConstants;
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
        $allCountries = Country::query()->select(CountryDBConstants::ID)->get()->pluck(CountryDBConstants::ID)->toArray();
        $ageTypes = ['kids', 'teens', 'any ages', 'adult'];
        $events = [];
        for ($i = 0; $i < 10000; $i++) {
            $authors = Arr::random($allAuthors);
            $countries = Arr::random($allCountries);
            $ageType = Arr::random($ageTypes);
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
                EventDBConstants::APPLIERS => null,
                EventDBConstants::INTERESTARS => null,
                EventDBConstants::RATING => null,
                EventDBConstants::IS_ONLINE => null,
                EventDBConstants::IS_OFFLINE => null,
                EventDBConstants::AUTHOR_ID => $authors,
                EventDBConstants::PARENT_ID => null,
                EventDBConstants::COUNTRY_ID => $countries,

            ];
        }
        $res = array_chunk($events, 1000);
        foreach ($res as $event) {
            Event::insert($event);
        }

    }
}
