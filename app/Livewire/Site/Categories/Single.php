<?php

namespace App\Livewire\Site\Categories;

use App\Models\Category;
use App\Traits\WithToggleFavorite;
use Livewire\Component;

class Single extends Component
{
    use WithToggleFavorite;
    public Category $category;
    public $perPage;
    public function mount(Category $category)
    {
        $this->category = $category;
        $this->perPage = get_option('posts_per_page', 10);
    }
    public function render()
    {
        return view('livewire.site.categories.single', [
            'posts' => $this->category->posts()->latest()->paginate($this->perPage, ['*'], 'posts_page'),
            'quotes' => $this->category->quotes()->latest()->paginate($this->perPage, ['*'], 'quotes_page'),
            'books' => $this->category->books()->latest()->paginate($this->perPage, ['*'], 'books_page'),
        ])->layout('layouts.curve', [
            'title' => $this->category->name,
            'seo_title' => $this->category->seo_title,
            'seo_description' => $this->category->seo_description,
        ]);
    }
}
