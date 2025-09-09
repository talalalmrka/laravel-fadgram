<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CoverLayout extends DefaultLayout
{
    public function __construct(
        public string $title = '',
        public bool $showTitle = true,
        public string|null $subtitle = null,
        public bool $showSubtitle = true,
        public string|null $secondSubtitle = null,
        public bool $showSecondSubtitle = true,
        public string|null $description = null,
        public string|null $color = 'primary',
        public string|null $image = null,
        public string $navbarclass = 'fixed top-0 start-0 end-0 z-40',
        public array $headerAtts = [],
    ) {
        //dd($this);
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.cover');
    }
}
