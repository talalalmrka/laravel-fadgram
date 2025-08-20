<?php

namespace App\Traits;

use Livewire\Attributes\On;

trait WithImageCrop
{
    public $showCrop = true;

    public function startCrop($model, $url)
    {
        if ($this->showCrop && $url) {
            $this->dispatch('crop', model: $model, url: $url);
            $this->showCrop = false;
        }
    }
    #[On('cropped')]
    public function onCropped()
    {
        $this->showCrop = true;
    }
}
