<?php

namespace Database\Seeders;

use App\Constants\DB\ApplierDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\Applier;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class ApplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $appliers = [];
        $eventsIds = Event::query()->select(EventDBConstants::ID)->get()->pluck(EventDBConstants::ID)->toArray();
        $userIds = User::query()->select(UserDBConstants::ID)->get()->pluck(UserDBConstants::ID)->toArray();
        for ($i = 0; $i < 100; $i++) {
            $appliers[] = [
                ApplierDBConstants::ID => Uuid::uuid7()->toString(),
                ApplierDBConstants::EVENT_ID => Arr::random($eventsIds),
                ApplierDBConstants::AUTHOR_ID => Arr::random($userIds),
            ];
        }
        Applier::insert($appliers);
    }
}
