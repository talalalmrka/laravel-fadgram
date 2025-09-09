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
        $cats = [
            'Motivational',
            'Funny',
            'Inspirational',
            'Life',
            'Positive',
            'Love',
            'Friendship',
            'Attitude',
            'Music',
            'Dreams'
        ];
        foreach ($cats as $cat) {
            Category::factory()->name($cat)->create();
        }
    }
}
