<?php

namespace Database\Seeders;

use App\Constants\DB\EventDBConstants;
use App\Constants\DB\InteresterDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\Event;
use App\Models\Interester;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class InteresterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interesters = [];
        for ($i = 0; $i < 100; $i++) {
            $interesters[] = [
                InteresterDBConstants::ID => Uuid::uuid7()->toString(),
                InteresterDBConstants::EVENT_ID => Arr::random(Event::query()
                    ->select(EventDBConstants::ID)
                    ->get()
                    ->pluck(EventDBConstants::ID)
                    ->toArray()),
                InteresterDBConstants::AUTHOR_ID => Arr::random(User::query()
                    ->select(UserDBConstants::ID)
                    ->get()
                    ->pluck(UserDBConstants::ID)
                    ->toArray()),
            ];
        }
        Interester::insert($interesters);
    }
}
