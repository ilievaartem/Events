<?php

namespace Database\Seeders;

use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $comments = [];
        for ($i = 0; $i < 100; $i++) {
            $comments[] = [
                CommentDBConstants::ID => Uuid::uuid7()->toString(),
                CommentDBConstants::EVENT_ID => Arr::random(Event::query()
                    ->select(EventDBConstants::ID)
                    ->get()
                    ->pluck(EventDBConstants::ID)
                    ->toArray()),
                CommentDBConstants::AUTHOR_ID => Arr::random(User::query()
                    ->select(UserDBConstants::ID)
                    ->get()
                    ->pluck(UserDBConstants::ID)
                    ->toArray()),
                CommentDBConstants::CONTENT => fake()->sentence(),
            ];
        }
        Comment::insert($comments);
    }
}
