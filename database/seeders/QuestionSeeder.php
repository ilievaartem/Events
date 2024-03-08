<?php

namespace Database\Seeders;

use App\Constants\DB\EventDBConstants;
use App\Constants\DB\InteresterDBConstants;
use App\Constants\DB\QuestionDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\Event;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $eventsIds = Event::query()->select(EventDBConstants::ID)->get()->pluck(EventDBConstants::ID)->toArray();
        $userIds = User::query()->select(UserDBConstants::ID)->get()->pluck(UserDBConstants::ID)->toArray();
        $questions = [];
        for ($i = 0; $i < 100; $i++) {
            $questions[] = [
                QuestionDBConstants::ID => Uuid::uuid7()->toString(),
                QuestionDBConstants::EVENT_ID => Arr::random($eventsIds),
                QuestionDBConstants::AUTHOR_ID => Arr::random($userIds),
                QuestionDBConstants::PARENT_ID => null,
                QuestionDBConstants::CONTENT => fake()->realText(),
            ];
        }
        Question::insert($questions);
    }
}
