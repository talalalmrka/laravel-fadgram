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
        Category::factory(5)->create();
        Category::factory(2)->parent(1)->create();
        Category::factory(2)->parent(3)->create();
        Category::factory(5)->tag()->create();
    }
}
