<?php

namespace Database\Seeders;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\TagDBConstants;
use App\Models\Category;
use App\Models\Event;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allTags = Tag::query()->select(TagDBConstants::ID)->get()->pluck(TagDBConstants::ID)->toArray();
        $allCategories = Category::query()->select(CategoryDBConstants::ID)->get()->pluck(CategoryDBConstants::ID)->toArray();
        $DBevents = Event::query()->select(EventDBConstants::ID)->limit(100)->get()->pluck(EventDBConstants::ID)->toArray();


        $sizeTags = count($allTags);
        $sizeCategories = count($allCategories);

        foreach ($DBevents as $eventId) {
            $currentTagsIds = array_slice($allTags, random_int(0, $sizeTags), random_int(3, 5));
            $currentCategoriesIds = array_slice($allCategories, random_int(0, $sizeCategories), random_int(3, 5));
            Event::find($eventId)->tags()->sync($currentTagsIds);
            Event::find($eventId)->categories()->sync($currentCategoriesIds);
        }
    }
}
