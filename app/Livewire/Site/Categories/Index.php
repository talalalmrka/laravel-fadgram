<?php

namespace App\Livewire\Site\Categories;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Category;
use App\Traits\WithToggleFavorite;

class Index extends ArchivePage
{
    use WithToggleFavorite;
    public function builder()
    {
        return Category::type('category');
    }
    public function render()
    {
        return view('livewire.site.categories.index', [
            'categories' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => get_option('archive_category_title',  __('Topics')),
            'seo_title' => get_option('archive_category_seo_title'),
            'seo_description' => get_option('archive_category_seo_description'),
        ]);
    }
}
