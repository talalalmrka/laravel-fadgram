<?php

namespace App\Livewire\Components;

use App\Models\Quote;
use App\Models\QuoteImage;
use App\Services\ImageService;
use Livewire\Component;

class DownloadQuote extends Component
{
    public Quote $quote;
    public QuoteImage $image;
    public $images;
    public $shuffle;
    public function mount()
    {
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
        // $this->js('lozad');
    }
    public function shuffleImages()
    {
        $this->images = QuoteImage::inRandomOrder()->take(5)->get();
        $this->image = $this->images->first();
        $this->shuffle = true;
        // $this->js('lozad');
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
        return view('livewire.components.download-quote');
    }
}
