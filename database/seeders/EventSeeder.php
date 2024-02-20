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
        $events = [];
        for ($i = 0; $i < 10; $i++) {
            $allCategoryIds = Category::query()->select(CategoryDBConstants::ID)->get()->pluck(CategoryDBConstants::ID)->toArray();
            $allTagIds = Tag::query()->select(TagDBConstants::ID)->get()->pluck(TagDBConstants::ID)->toArray();
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
                EventDBConstants::AGE_FROM => random_int(0, 18),
                EventDBConstants::AGE_TO => random_int(40, 100),
                EventDBConstants::CATEGORIES_IDS => json_encode(array_slice(shuffle($allCategoryIds) ? $allCategoryIds : array_reverse($allCategoryIds), 0, mt_rand(3, 5))),
                EventDBConstants::TAGS_IDS => json_encode(array_slice(shuffle($allTagIds) ? $allTagIds : array_reverse($allTagIds), 0, mt_rand(3, 5))),
                EventDBConstants::APPLIERS => null,
                EventDBConstants::INTERESTARS => null,
                EventDBConstants::RATING => null,
                EventDBConstants::IS_ONLINE => null,
                EventDBConstants::IS_OFFLINE => null,
                EventDBConstants::AUTHOR_ID => Arr::random(User::query()->select(UserDBConstants::ID)->get()->pluck(UserDBConstants::ID)->toArray()),
                EventDBConstants::PARENT_ID => null,
                EventDBConstants::CITY_ID => Arr::random(City::query()->select(CityDBConstants::ID)->get()->pluck(CityDBConstants::ID)->toArray()),
                EventDBConstants::COUNTRY_ID => Arr::random(Country::query()->select(CountryDBConstants::ID)->get()->pluck(CountryDBConstants::ID)->toArray()),

            ];
        }
        Event::insert($events);
    }
}
