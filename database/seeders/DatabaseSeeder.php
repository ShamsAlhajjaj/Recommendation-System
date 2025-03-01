<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Order matters for relationships
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
