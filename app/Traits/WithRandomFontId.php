<?php

namespace App\Traits;

use App\Models\Font;

trait WithRandomFontId
{
    public function randomFontId()
    {
        $font = Font::inRandomOrder()->first();
        return $font?->id;
    }
}
