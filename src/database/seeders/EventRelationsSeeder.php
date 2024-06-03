<?php

namespace Database\Seeders;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\TagDBConstants;
use App\Models\Category;
use App\Models\Event;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dateFirst = Carbon::create(2024, 1, 1);
        $dateSecond = Carbon::create(2024, 5, 30);
        $allTags = Tag::query()->select(TagDBConstants::ID)->get()->pluck(TagDBConstants::ID)->toArray();
        $allCategories = Category::query()->select(CategoryDBConstants::ID)->get()->pluck(CategoryDBConstants::ID)->toArray();
        $DBevents = Event::query()->select(EventDBConstants::ID)->limit(100)->get()->pluck(EventDBConstants::ID)->toArray();

        $sizeTags = count($allTags);
        $sizeCategories = count($allCategories);

        foreach ($DBevents as $eventId) {
            $currentTagsIds = array_slice($allTags, random_int(0, $sizeTags - 1), random_int(3, 5));
            $currentCategoriesIds = array_slice($allCategories, random_int(0, $sizeCategories - 1), random_int(3, 5));

            $tagsWithTimestamps = [];
            foreach ($currentTagsIds as $tagId) {
                $randomTimestamp = mt_rand($dateFirst->timestamp, $dateSecond->timestamp);
                $createdAt = Carbon::createFromTimestamp($randomTimestamp);
                $tagsWithTimestamps[$tagId] = ['created_at' => $createdAt];
            }

            $categoriesWithTimestamps = [];
            foreach ($currentCategoriesIds as $categoryId) {
                $randomTimestamp = mt_rand($dateFirst->timestamp, $dateSecond->timestamp);
                $createdAt = Carbon::createFromTimestamp($randomTimestamp);
                $categoriesWithTimestamps[$categoryId] = ['created_at' => $createdAt];
            }

            $event = Event::find($eventId);
            $event->tags()->sync($tagsWithTimestamps);
            $event->categories()->sync($categoriesWithTimestamps);
        }
    }
}
