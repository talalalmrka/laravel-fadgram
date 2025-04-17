<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Traits\WithToast;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Add extends Component
{
    use WithToast;
    public Menu $menu;
    public $selectAllPages = false;
    public $pages = [];
    public $selectAllPosts = false;
    public $posts = [];
    public $selectAllCategories = false;
    public $categories = [];
    public $searchCategories = [];
    public $custom = [];
    public $items = [];
    public function mount(Menu $menu)
    {
        $this->menu = $menu;
        //$this->loadItems();
    }
    #[Computed]
    public function categoryOptions()
    {
        $query = Category::type('category')->where('parent_id', null)->with('children');
        if ($this->searchCategories) {
            $query->where(function ($q) {
                foreach (['name', 'description', 'slug'] as $col) {
                    $q->orWhere($col, 'like', "%{$this->searchCategories}%");
                }
            });
        }
        return $query->get();
    }
    public function updatedSelectAllPages($value)
    {
        if ($value) {
            $this->pages = Page::all()->pluck('id')->toArray();
        } else {
            $this->pages = [];
        }
    }
    public function updatedSelectAllPosts($value)
    {
        if ($value) {
            $this->posts = Post::all()->pluck('id')->toArray();
        } else {
            $this->posts = [];
        }
    }

    public function addPages()
    {
        $this->validate([
            'pages' => ['required', 'array'],
            'pages.*' => ['required', 'integer', Rule::exists('posts', 'id')->where('type', 'page')],
        ]);

        foreach ($this->pages as $pageId) {
            $page = Page::find($pageId);
            $this->menu->items()->create([
                'type' => 'page',
                'page_id' => $page->id,
                'name' => $page->name,
                'order' => $this->menu->items()->max('order') + 1,
            ]);
        }

        $this->reset('pages', 'selectAllPages');
        //$this->loadItems();
        $this->addSuccess('pages_status', __('Added successfully.'));
        $this->dispatch('items-added');
    }

    public function addPosts()
    {
        $this->validate([
            'posts' => ['required', 'array'],
            'posts.*' => ['required', 'integer', Rule::exists('posts', 'id')->where('type', 'post')],
        ]);

        foreach ($this->posts as $postId) {
            $post = Post::find($postId);
            $this->menu->items()->create([
                'type' => 'post',
                'post_id' => $post->id,
                'name' => $post->name,
                'order' => $this->menu->items()->max('order') + 1,
            ]);
        }

        $this->reset('posts', 'selectAllPosts');
        //$this->loadItems();
        $this->addSuccess('posts_status', __('Added successfully.'));
        $this->dispatch('items-added');
    }
    public function addCategories()
    {
        $this->validate([
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
        ]);

        foreach ($this->categories as $catId) {
            $category = Category::find($catId);
            $this->menu->items()->create([
                'type' => 'category',
                'post_id' => $category->id,
                'name' => $category->name,
                'order' => $this->menu->items()->max('order') + 1,
            ]);
        }

        $this->reset('categories', 'selectAllCategories');
        //$this->loadItems();
        $this->addSuccess('categories_status', __('Added successfully.'));
        $this->dispatch('items-added');
    }

    public function addCustom()
    {
        $this->validate([
            'custom' => ['required', 'array'],
            'custom.name' => ['nullable', 'string', 'max:255'],
            'custom.icon' => ['nullable', 'string', 'max:255'],
            'custom.url' => ['nullable', 'string', 'max:255'],
        ]);
        $custom = $this->menu->items()->create([
            'type' => 'custom',
            'name' => $this->custom['name'],
            'icon' => $this->custom['icon'],
            'url' => $this->custom['url'],
            'order' => $this->menu->items()->max('order') + 1,
        ]);
        if ($custom) {
            $this->reset('custom');
            $this->addSuccess('custom_status', __('Added successfully.'));
            $this->dispatch('items-added');
        } else {
            $this->addSuccess('custom_status', __('Failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.menus.add');
    }
}
