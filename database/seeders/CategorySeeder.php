<?php

namespace Database\Seeders;

use App\Constants\DB\CategoryDBConstants;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [];
        for ($i = 0; $i < 100; $i++) {
            $category[] = [
                CategoryDBConstants::NAME => fake()->word(),
            ];
        }
        Category::insert($category);
    }
}
