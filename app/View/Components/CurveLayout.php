<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CurveLayout extends Component
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
        public $avatarImage = null,
        public $avatarText = null,
    ) {
        // dd($this->navbarclass);
        // $this->setupNavbarClass();
    }
    public function setupNavbarClass()
    {
        $navbarColors = [
            'primary' => 'navbar-transparent-primary',
            'secondary' => 'navbar-transparent-secondary',
            'red' => 'navbar-transparent-red',
            'blue' => 'navbar-transparent-blue',
            'green' => 'navbar-transparent-green',
            'yellow' => 'navbar-transparent-yellow',
            'pink' => 'navbar-transparent-pink',
            'purple' => 'navbar-transparent-purple',
            'indigo' => 'navbar-transparent-indigo',
            'gray' => 'navbar-transparent-gray',
            'orange' => 'navbar-transparent-orange',
            'teal' => 'navbar-transparent-teal',
            'cyan' => 'navbar-transparent-cyan',
            'lime' => 'navbar-transparent-lime',
            'amber' => 'navbar-transparent-amber',
            'emerald' => 'navbar-transparent-emerald',
            'fuchsia' => 'navbar-transparent-fuchsia',
            'rose' => 'navbar-transparent-rose',
            'sky' => 'navbar-transparent-sky',
            'slate' => 'navbar-transparent-slate',
            'zinc' => 'navbar-transparent-zinc',
            'neutral' => 'navbar-transparent-neutral',
            'stone' => 'navbar-transparent-stone',
        ];
        $navbarColor = data_get($navbarColors, $this->color, 'navbar-transparent-primary');
        $this->navbarclass = css_classes(['fixed top-0 start-0 end-0 z-40', $navbarColor => $navbarColor]);
    }
    /*public $title = null;
    public $showTitle = true;
    public $subtitle = null;
    public $secondSubtitle = null;
    public $showSecondSubtitle = true;
    public $showSubtitle = true;
    public $description = null;
    public $color = 'primary';
    public $headerClass = null;
    public $headerAtts = [];*/
    /*public function __construct(
        $title = '',
        $showTitle = true,
        $subtitle = null,
        $showSubtitle = true,
        $secondSubtitle = null,
        $showSecondSubtitle = true,
        $description = null,
        $color = 'primary',
        $headerClass = null,
        $headerAtts = [],
    ) {
        $this->title = $title;
        $this->showTitle = $showTitle;
        $this->subtitle = $subtitle;
        $this->showSubtitle = $showSubtitle;
        $this->secondSubtitle = $secondSubtitle;
        $this->showSecondSubtitle = $showSecondSubtitle;
        $this->description = $description;
        $this->color = $color;
        $this->headerClass = $headerClass;
        $this->headerAtts = $headerAtts;

    }*/
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.curve'/* , [
            'title' => $this->title,
            'showTitle' => $this->showTitle,
            'subtitle' => $this->subtitle,
            'showSubtitle' => $this->showSubtitle,
            'secondSubtitle' => $this->secondSubtitle,
            'showSecondSubtitle' => $this->showSecondSubtitle,
            'description' => $this->description,
            'color' => $this->color,
            'headerClass' => $this->headerClass,
            'headerAtts' => $this->headerAtts,
        ] */);
    }
}
