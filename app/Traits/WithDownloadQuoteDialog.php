<?php

namespace App\Traits;

use App\Models\Quote;

trait WithDownloadQuoteDialog
{
    public function downloadQuote(Quote $quote)
    {
        $this->dispatch('download-quote', $quote->id);
    }
}
