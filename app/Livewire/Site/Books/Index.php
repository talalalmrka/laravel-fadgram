<?php

namespace App\Livewire\Site\Books;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Book;

class Index extends ArchivePage
{
    public function builder()
    {
        return Book::status('publish');
    }
    public function toggleFavorite(Book $book)
    {
        $book->toggleFavorite();
    }
    public function render()
    {
        return view('livewire.site.books.index', [
            'books' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => __('Books'),
        ]);
    }
}
