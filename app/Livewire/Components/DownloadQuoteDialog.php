<?php

namespace App\Livewire\Components;

use App\Models\Quote;
use App\Models\QuoteImage;
use App\Services\ImageService;
use Livewire\Attributes\On;
use Livewire\Component;

class DownloadQuoteDialog extends Component
{
    public Quote|null $quote = null;
    public QuoteImage $image;
    public $images;
    public $shuffle = false;
    public $show = false;
    public function updatedShow($value)
    {
        if (!$value) {
            $this->quote = null;
        }
    }
    public function open()
    {
        $this->show = true;
    }
    public function close()
    {
        $this->show = false;
        $this->quote = null;
    }
    #[On('download-quote')]
    public function onDownloadQuote(Quote $quote)
    {
        $this->quote = $quote;
        $this->loadImages();
        $this->open();
    }
    public function loadImages()
    {
        if ($this->quote) {
            $this->images = $this->quote->images;
            $this->image = $this->images->first();
            $this->shuffle = false;
        }
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
        return view('livewire.components.download-quote-dialog');
    }
}
