<?php

namespace App\Livewire\Site\Authors;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Author;
use App\Traits\WithToggleFavorite;

class Index extends ArchivePage
{
    use WithToggleFavorite;
    public function builder()
    {
        return Author::status('publish');
    }
    public function render()
    {
        return view('livewire.site.authors.index', [
            'authors' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => get_option('archive_author_title',  __('Authors')),
            'seo_title' => get_option('archive_author_seo_title'),
            'seo_description' => get_option('archive_author_seo_description'),
        ]);
    }
}
