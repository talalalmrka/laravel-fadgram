<?php

namespace App\Livewire\Components;

use Illuminate\Http\Request;
use Livewire\Component;

class Carousel extends Component
{

    public function mount(Request $request) {}
    public function carousel()
    {
        return [
            'autoplay' => true,
            'controls' => true,
            'indicators' => true,
            'transition' => 'slide',
            'duration' => 700,
            'interval' => 3500,
            'slides' => arr_map(range(1, 3), fn($i) => [
                'title' => "Slide $i title",
                'subtitle' => "Slide $i subtitle",
                'url' => '#',
                'image' => route('imgen.quote-image', $i),
            ])
        ];
    }
    public function render()
    {
        return view('livewire.components.carousel', [
            'carousel' => $this->carousel(),
        ]);
    }
}
