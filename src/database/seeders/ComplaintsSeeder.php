<?php

namespace Database\Seeders;

use App\Constants\DB\ComplaintDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\Complaint;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class ComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $eventsIds = Event::query()->select(EventDBConstants::ID)->get()->pluck(EventDBConstants::ID)->toArray();
        $userIds = User::query()->select(UserDBConstants::ID)->get()->pluck(UserDBConstants::ID)->toArray();
        $complaints = [];
        for ($i = 0; $i < 10; $i++) {
            $complaints[] = [
                ComplaintDBConstants::ID => Uuid::uuid7()->toString(),
                ComplaintDBConstants::EVENT_ID => Arr::random($eventsIds),
                ComplaintDBConstants::AUTHOR_ID => Arr::random($userIds),
                ComplaintDBConstants::RESOLVER_ID => null,
                ComplaintDBConstants::ASSIGNEE => null,
                ComplaintDBConstants::CAUSE_MESSAGE => fake()->sentence(),
                ComplaintDBConstants::CAUSE_DESCRIPTION => fake()->realText(),
                ComplaintDBConstants::RESOLVE_MESSAGE => null,
                ComplaintDBConstants::RESOLVE_DESCRIPTION => null,
                ComplaintDBConstants::READ_AT => null,
                ComplaintDBConstants::RESOLVED_AT => null,
                ComplaintDBConstants::DELETED_AT => null,
            ];
        }
        Complaint::insert($complaints);
    }
}
