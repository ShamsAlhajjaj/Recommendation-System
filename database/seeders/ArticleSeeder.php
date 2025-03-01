<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory()->count(10)->create()->each(function ($article) {
            $categoryIds = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $article->categories()->attach($categoryIds);
        });
    }
} 