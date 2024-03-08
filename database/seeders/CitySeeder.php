<?php

namespace Database\Seeders;

use App\Constants\DB\CityDBConstants;
use App\Constants\DB\CountryDBConstants;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [];
        $countryIds = Country::query()->pluck(CountryDBConstants::ID)->toArray();
        for ($i = 0; $i < 100; $i++) {
            $cities[] = [
                CityDBConstants::NAME => fake()->city(),
                CityDBConstants::COUNTRY_ID => Arr::random($countryIds),
            ];
        }
        City::insert($cities);
    }
}
