<?php

namespace App\Livewire\Site\Quotes;

use App\Models\Quote;
use App\Models\QuoteImage;
use App\Services\ImageService;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToast;
use Livewire\Component;

class Single extends Component
{
    use WithToast, WithDownloadQuoteDialog;
    public Quote $quote;
    public $editPermission;
    public $editUrl;
    public $related;
    public $relatedLabel;
    public $booksEnabled;
    public $books;
    public $booksLabel;
    public $images;
    public $shuffle;
    public QuoteImage $image;
    public function mount(Quote $quote)
    {
        $quote->viewsPlus();
        $this->quote = $quote;
        $this->related = (bool) get_option('related_quotes_enabled', false) ? $this->quote->related() : null;
        $this->relatedLabel = get_option('related_quotes_label');
        $this->booksEnabled = (bool) get_option('quote_books_enabled');
        $this->loadImages();
    }
    public function loadImages()
    {
        $this->images = $this->quote->images;
        $this->image = $this->images->first();
        $this->shuffle = false;
    }
    public function selectImage(QuoteImage $quoteImage)
    {
        $this->image = $quoteImage;
    }
    public function shuffleImages()
    {
        $this->images = QuoteImage::inRandomOrder()->take(5)->get();
        $this->image = $this->images->first();
        $this->shuffle = true;
    }
    public function downloadImage()
    {
        $img = ImageService::forQuote($this->quote, $this->image);
        return response()->streamDownload(function () use ($img) {
            echo $img->toString();
        }, "{$this->quote->slug}-{$this->image->id}.{$this->image->format}", [
            'Content-Type' => "image/{$this->image->format}",
        ]);
    }
    public function render()
    {
        return view('livewire.site.quotes.single')->layout('layouts.curve', [
            'title' => $this->quote->name,
            'seo_title' => $this->quote->seo_title,
            'seo_description' => $this->quote->seo_description,
            /* 'subtitle' => container([
                'tag' => 'span',
                'icon' => 'bi-person-fill',
                'content' => $this->quote->author_name,
                'class' => 'justify-center',
            ]),
            'secondSubtitle' => container([
                'tag' => 'span',
                'icon' => 'bi-calendar-fill',
                'content' => $this->quote->date_ago,
                'class' => 'justify-center',
            ]), */
            'image' => $this->quote->getThumbnailUrl('lg'),
            'avatarImage' => $this->quote->author_thumbnail,
        ]);
    }
}
