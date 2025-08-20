<?php

namespace App\Livewire\Site\Categories;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Category;

class Index extends ArchivePage
{
    public function builder()
    {
        return Category::category();
    }
    public function toggleFavorite(Category $category)
    {
        $category->toggleFavorite();
    }
    public function render()
    {
        return view('livewire.site.categories.index', [
            'categories' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => __('Categories'),
        ]);
    }
}
