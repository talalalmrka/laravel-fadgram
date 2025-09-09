<?php

namespace App\Livewire\Site\Authors;

use App\Models\Author;
use App\Traits\WithToggleFavorite;
use Livewire\Component;

class Single extends Component
{
    use WithToggleFavorite;
    public Author $author;
    public $perPage;
    public function mount(Author $author)
    {
        $this->perPage = get_option('posts_per_page', 10);
    }

    public function render()
    {
        return view('livewire.site.authors.single', [
            'quotes' => $this->author->quotes()->latest()->paginate($this->perPage, ['*'], 'quotes_page'),
            'books' => $this->author->books()->latest()->paginate($this->perPage, ['*'], 'books_page'),
        ])->layout('layouts.curve', [
            'title' => $this->author->name,
            'seo_title' => $this->author->seo_title,
            'seo_description' => $this->author->seo_description,
        ]);
    }
}
