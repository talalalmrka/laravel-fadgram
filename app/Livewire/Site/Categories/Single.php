<?php

namespace App\Livewire\Site\Categories;

use App\Models\Category;
use Livewire\Component;

class Single extends Component
{
    public Category $category;
    public $posts;
    public $quotes;
    public $books;
    public function mount(Category $category)
    {
        $this->category = $category;
        $this->posts = $this->category->posts;
        $this->quotes = $this->category->quotes;
        $this->books = $this->category->books;
    }
    public function render()
    {
        return view('livewire.site.categories.single')->layout('layouts.curve', [
            'title' => __(get_option('category_title', 'Category :name'), ['name' => $this->category->name]),
        ]);
    }
}
