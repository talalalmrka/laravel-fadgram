<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DefaultLayout extends AppLayout
{
    public function __construct(
        public string $title = '',
        public string|null $description = null,
        public string $navbarclass = 'header sticky top-0 bg-gray-50 dark:bg-gray-700 max-w-full z-50 shadow-xs',
        public string $logo_theme = 'dark',
        public string|null $seo_title = null,
        public string|null $seo_description = null,
    ) {}
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.default');
    }
}
