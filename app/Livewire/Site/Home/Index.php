<?php

namespace App\Livewire\Site\Home;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends ArchivePage
{

    public $title;
    public $front_type;
    public $front_page;
    public $posts_per_page;

    public function mount()
    {
        $this->title = __('Home');
        $this->front_type = get_option('front_type', 'posts');
        $this->front_page = get_option('front_page');
        $this->posts_per_page = get_option('posts_per_page', 10);
    }
    public function builder()
    {
        return Post::where('type', 'post')->where('status', 'publish');
    }
    public function render()
    {
        if ($this->front_type === 'posts') {
            // Show latest posts
            /* $posts = Post::where('type', 'post')
                ->orderBy('created_at', 'desc')
                ->paginate($this->posts_per_page); */

            return view('livewire.site.posts.index', [
                'posts' => $this->items(),
            ])->layout('layouts.default', [
                'title' => $this->title,
            ]);
        } elseif ($this->front_type === 'page' && $this->front_page) {
            // Show static page
            $page = Post::find($this->front_page);
            if ($page && $page->type === 'page') {
                return view('livewire.site.posts.item', [
                    'post' => $page
                ])->layout($page->getLayout(), [
                    'title' => $page->name,
                    'subtitle' => "<i class=\"icon bi-person-fill\"></i> {$page->author_name}",
                    'secondSubtitle' => "<i class=\"icon bi-calendar-fill\"></i> {$page->date}",
                    'image' => $page->getThumbnailUrl('lg')
                ]);
            }
        }

        // Default home page
        return view('livewire.site.home.index')->layout('layouts.default', [
            'title' => $this->title,
        ]);
    }
}
