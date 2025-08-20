<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\QuoteImage;

trait WithRandomQuoteImageId
{
    public function randomQuoteImageId()
    {
        $quoteImage = QuoteImage::inRandomOrder()->first();
        return $quoteImage?->id;
    }
}
