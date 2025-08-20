<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(30)->create()->each(function (Category $category) {
            Category::factory(3)->parent($category->id)->create();
        });
        Category::factory(30)->tag()->create();
    }
}
