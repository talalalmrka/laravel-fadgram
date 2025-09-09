<?php

namespace App\Livewire\Dashboard\Home;

use App\Models\Book;
use App\Models\Category;
use App\Models\Post;
use App\Models\Quote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Index extends Component
{
    public $title;

    public function mount()
    {
        $this->title = __('Dashboard');
    }

    public function stats()
    {
        return [
            [
                'icon' => 'bi-people',
                'title' => __('Users'),
                'class' => 'overview-card-blue',
                'details' => human_number(User::count()),
            ],
            [
                'icon' => 'bi-quote',
                'title' => __('Quotes'),
                'class' => 'overview-card-green',
                'details' => human_number(Quote::publish()->count()),
            ],
            [
                'icon' => 'bi-book',
                'title' => __('Books'),
                'class' => 'overview-card-teal',
                'details' => human_number(Book::publish()->count()),
            ],
            [
                'icon' => 'bi-newspaper',
                'title' => __('Posts'),
                'class' => 'overview-card-orange',
                'details' => human_number(Post::type('post')->publish()->count()),
            ],
        ];
    }

    public function blocks()
    {
        return [
            view('livewire.dashboard.home.stats', [
                'stats' => $this->stats(),
            ]),
        ];
    }


    public function render()
    {
        return view('livewire.dashboard.home.index', [
            'blocks' => $this->blocks(),
        ])->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}
