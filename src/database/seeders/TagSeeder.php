<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Constants\DB\TagDBConstants;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [];
        for ($i = 0; $i < 100; $i++) {
            $category[] = [
                TagDBConstants::NAME => fake()->word(),
            ];
        }
        Tag::insert($category);
    }
}
