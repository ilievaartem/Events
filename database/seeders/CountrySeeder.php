<?php

namespace Database\Seeders;

use App\Constants\DB\CountryDBConstants;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = [];
        for ($i = 0; $i < 100; $i++) {
            $countries[] = [
                CountryDBConstants::NAME => fake()->country(),
            ];
        }
        Country::insert($countries);
    }

}
