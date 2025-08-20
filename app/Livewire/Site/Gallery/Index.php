<?php

namespace App\Livewire\Site\Gallery;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Quote;
use App\Models\QuoteImage;
use App\Traits\WithDownloadQuoteDialog;

class Index extends ArchivePage
{
    use WithDownloadQuoteDialog;
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
    public function toggleFavorite(Quote $quote)
    {
        $quote->toggleFavorite();
    }
    public function photos()
    {
        return arr_map(range(1, 30), function ($i) {
            $width = fake()->randomElement([630, 720, 1024, 500]);
            $height = fake()->randomElement([630, 720, 1024, 1500]);
            $text = "{$width}x{$height}";
            $img = QuoteImage::inRandomOrder()->first()?->image_path;
            return route('imgen', [
                'img' => $img,
                'width' => $width,
                'height' => $height,
                'text' => $text,
            ]);
        });
    }
    public function render()
    {
        return view('livewire.site.gallery.index', [
            'quotes' => $this->items(),
            'photos' => $this->photos(),
        ])->layout('layouts.curve', [
            'title' => __('Gallery'),
        ]);
    }
}
