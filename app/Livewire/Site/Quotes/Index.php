<?php

namespace App\Livewire\Site\Quotes;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Quote;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToggleFavorite;

class Index extends ArchivePage
{
    use WithDownloadQuoteDialog,
        WithToggleFavorite;
    public function builder()
    {
        return Quote::status('publish');
    }

    public function render()
    {
        return view('livewire.site.quotes.index', [
            'quotes' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => get_option('archive_quote_title',  __('Quotes')),
            'seo_title' => get_option('archive_quote_seo_title'),
            'seo_description' => get_option('archive_quote_seo_description'),
        ]);
    }
}
