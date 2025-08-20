<?php

namespace App\Livewire\Site\Quotes;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Quote;
use App\Traits\WithDownloadQuoteDialog;

class Index extends ArchivePage
{
    use WithDownloadQuoteDialog;
    public function builder()
    {
        return Quote::status('publish');
    }
    public function toggleFavorite(Quote $quote)
    {
        $quote->toggleFavorite();
    }
    public function render()
    {
        return view('livewire.site.quotes.index', [
            'quotes' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => __('Quotes'),
        ]);
    }
}
