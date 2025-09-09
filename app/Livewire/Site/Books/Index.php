<?php

namespace App\Livewire\Site\Books;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Book;
use App\Traits\WithToggleFavorite;

class Index extends ArchivePage
{
    use WithToggleFavorite;
    public function builder()
    {
        return Book::status('publish');
    }
    public function render()
    {
        return view('livewire.site.books.index', [
            'books' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => get_option('archive_book_title',  __('Books')),
            'seo_title' => get_option('archive_book_seo_title'),
            'seo_description' => get_option('archive_book_seo_description'),
        ]);
    }
}
