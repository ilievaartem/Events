<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            CountrySeeder::class,
            GeoSeeder::class,
            EventSeeder::class,
            EventRelationsSeeder::class,
            CommentSeeder::class,
            MediaSeeder::class,
            InteresterSeeder::class,
            ApplierSeeder::class,
            QuestionSeeder::class,
            ComplaintsSeeder::class,
        ]);
    }
}
