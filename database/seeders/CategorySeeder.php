<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Technology',
            'Science',
            'Health',
            'Business',
            'Entertainment',
            'Sports',
            'Politics',
            'Education',
            'Travel',
            'Food'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
} 