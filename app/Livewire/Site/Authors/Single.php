<?php

namespace App\Livewire\Site\Authors;

use App\Models\Author;
use Livewire\Component;

class Single extends Component
{
    public Author $author;
    public $posts;
    public $quotes;
    public $books;
    public function mount(Author $author)
    {
        $this->author = $author;
        $this->posts = $this->author->posts;
        $this->quotes = $this->author->quotes;
        $this->books = $this->author->books;
    }

    public function render()
    {
        return view('livewire.site.authors.single')->layout('layouts.curve', [
            'title' => __(get_option('author_title', 'Author: :name'), ['name' => $this->author->name]),
        ]);
    }
}
