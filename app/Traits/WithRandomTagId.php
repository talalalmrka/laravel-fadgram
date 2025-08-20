<?php

namespace App\Traits;

use App\Models\Category;

trait WithRandomTagId
{
    public function randomTagId()
    {
        $tag = Category::type('tag')->inRandomOrder()->first();
        return $tag?->id;
    }
}
