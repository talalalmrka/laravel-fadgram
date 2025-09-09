<?php

namespace App\Livewire\Site\Home;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Post;
use App\Traits\WithToggleFavorite;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends ArchivePage
{
    use WithToggleFavorite;
    public $front_type;
    public $front_page;
    public $posts_per_page;
    public $title;
    public $seo_title;
    public $seo_description;
    public function mount()
    {

        $this->front_type = get_option('front_type', 'posts');
        $this->front_page = get_option('front_page');
        $this->posts_per_page = get_option('posts_per_page', 10);
        $this->title = __('Home');
        $this->seo_title = $this->title;
        $this->seo_description = get_option('description');
    }
    public function builder()
    {
        return Post::where('type', 'post')->where('status', 'publish');
    }
    public function render()
    {
        if ($this->front_type === 'posts') {
            return view('livewire.site.posts.index', [
                'posts' => $this->items(),
            ])->layout('layouts.curve', [
                'title' => $this->title,
                'seo_title' => $this->seo_title,
                'seo_description' => $this->seo_description,
            ]);
        } elseif ($this->front_type === 'page' && $this->front_page) {
            $page = Post::find($this->front_page);
            if ($page && $page->type === 'page') {
                return view('livewire.site.posts.page')->layout($page->layout, [
                    'title' => $page->name,
                    'seo_title' => $page->seo_title,
                    'seo_description' => $page->seo_description,
                ]);
            }
        }

        // Default home page
        return view('livewire.site.home.index')->layout('layouts.default', [
            'title' => $this->title,
        ]);
    }
}
