<?php

namespace App\Traits;

use App\Models\Category;

trait WithRandomCategoryId
{
    public function randomCategoryId()
    {
        $cat = Category::type('category')->inRandomOrder()->first();
        return $cat?->id;
    }
}
