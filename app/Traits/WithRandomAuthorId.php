<?php

namespace App\Traits;

use App\Models\Author;

trait WithRandomAuthorId
{
    public function randomAuthorId()
    {
        $author = Author::inRandomOrder()->first();
        return $author?->id;
    }
}
