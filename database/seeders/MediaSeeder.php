<?php

namespace Database\Seeders;

use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\MediaDBConstants;
use App\Constants\DB\UserDBConstants;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $media = [];
        for ($i = 0; $i < 100; $i++) {
            $media[] = [
                MediaDBConstants::ID => Uuid::uuid7()->toString(),
                MediaDBConstants::EVENT_ID => Arr::random(Event::query()
                    ->select(EventDBConstants::ID)
                    ->get()
                    ->pluck(EventDBConstants::ID)
                    ->toArray()),
                MediaDBConstants::AUTHOR_ID => Arr::random(User::query()
                    ->select(UserDBConstants::ID)
                    ->get()
                    ->pluck(UserDBConstants::ID)
                    ->toArray()),
                MediaDBConstants::COMMENT_ID => Arr::random(Comment::query()
                    ->select(CommentDBConstants::ID)
                    ->get()
                    ->pluck(CommentDBConstants::ID)
                    ->toArray()),
                MediaDBConstants::PATH => fake()->filePath(),
                MediaDBConstants::TYPE => fake()->fileExtension(),
            ];
        }
        Media::insert($media);
    }
}
