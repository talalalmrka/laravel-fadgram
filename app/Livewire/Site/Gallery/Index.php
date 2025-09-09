<?php

namespace App\Livewire\Site\Gallery;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Quote;
use App\Models\QuoteImage;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToggleFavorite;

class Index extends ArchivePage
{
    use WithDownloadQuoteDialog,
        WithToggleFavorite;
    public $perPage = 18;
    public $filters = [
        'search' => null,
        'sort' => 'newest_top',
        'category' => null,
    ];

    public function builder()
    {
        return Quote::status('publish');
    }

    public function render()
    {
        return view('livewire.site.gallery.index', [
            'quotes' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => get_option('archive_gallery_title',  __('Gallery')),
            'seo_title' => get_option('archive_gallery_seo_title'),
            'seo_description' => get_option('archive_gallery_seo_description'),
        ]);
    }
}
