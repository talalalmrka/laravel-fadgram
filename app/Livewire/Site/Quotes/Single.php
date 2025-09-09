<?php

namespace App\Livewire\Site\Quotes;

use App\Models\Quote;
use App\Models\QuoteImage;
use App\Services\ImageService;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToast;
use App\Traits\WithToggleFavorite;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Single extends Component
{
    use WithToast,
        WithDownloadQuoteDialog,
        WithToggleFavorite;
    #[Locked]
    public Quote $quote;
    public $editPermission;
    public $editUrl;
    public $related;
    public $relatedLabel;
    public $booksEnabled;
    public $books;
    public $booksLabel;
    // public $images;
    public $shuffle;
    // public QuoteImage $image;
    public function mount(Quote $quote)
    {
        $quote->viewsPlus();
        $this->quote = $quote;
        $this->related = (bool) get_option('related_quotes_enabled', false) ? $this->quote->related() : null;
        $this->relatedLabel = get_option('related_quotes_label');
        $this->booksEnabled = (bool) get_option('quote_books_enabled');
        /*         $this->shuffle = request('suffle', false);
        $this->images = $this->shuffle ? QuoteImage::inRandomOrder()->take(5)->get() : $this->quote->images;
        $this->image = $this->images->first(); */
        // $this->loadImages();
    }
    /* public function loadImages()
    {

        $this->shuffle = false;
    }
    public function selectImage(QuoteImage $quoteImage)
    {
        $this->image = $quoteImage;
        // $this->js('lozad');
    }
    public function shuffleImages()
    {
        $this->images = QuoteImage::inRandomOrder()->take(5)->get();
        $this->image = $this->images->first();
        $this->shuffle = true;
        // $this->js('lozad');
    } */
    public function downloadImage()
    {
        $img = ImageService::forQuote($this->quote, $this->image);
        return response()->streamDownload(function () use ($img) {
            echo $img->toString();
        }, "{$this->quote->slug}-{$this->image->id}.{$this->image->format}", [
            'Content-Type' => "image/{$this->image->format}",
        ]);
    }
    public function shuffle(): bool
    {
        return boolval(request('shuffle'));
    }
    public function images()
    {
        return $this->shuffle() ? QuoteImage::inRandomOrder()->take(5)->get() : $this->quote->images;
    }
    public function image()
    {
        $imageId = request('img');
        if ($imageId) {
            $image = QuoteImage::find($imageId);
            if ($image) {
                return $image;
            }
        }
        return $this->images()->first();
    }
    public function render()
    {
        $images = $this->shuffle ? QuoteImage::inRandomOrder()->take(5)->get() : $this->quote->images;


        return view('livewire.site.quotes.single', [
            'shuffle' => $this->shuffle(),
            'image' => $this->image(),
            'images' => $this->images(),
        ])->layout('layouts.curve', [
            'title' => $this->quote->author_name,
            'seo_title' => $this->quote->seo_title,
            'seo_description' => $this->quote->seo_description,
        ]);
    }
}
