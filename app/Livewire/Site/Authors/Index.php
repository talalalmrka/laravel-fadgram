<?php

namespace App\Livewire\Site\Authors;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Author;

class Index extends ArchivePage
{
    public function builder()
    {
        return Author::status('publish');
    }
    public function toggleFavorite(Author $author)
    {
        $author->toggleFavorite();
    }
    public function render()
    {
        return view('livewire.site.authors.index', [
            'authors' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => __('Authors'),
        ]);
    }
}
