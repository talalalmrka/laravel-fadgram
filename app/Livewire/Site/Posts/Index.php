<?php

namespace App\Livewire\Site\Posts;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Post;
use App\Traits\WithToast;

class Index extends ArchivePage
{
    public $layout;
    public function mount()
    {
        $this->title = is_home() ? __('Home') : get_option('blog_title', __('Blog'));
        $this->layout = is_home() ? 'layouts.default' : 'layouts.curve';
    }
    public function builder()
    {
        return Post::where('type', 'post')->where('status', 'publish');
    }
    public function toggleFavorite(Post $post)
    {
        $post->toggleFavorite();
    }
    public function render()
    {
        return view('livewire.site.posts.index', [
            'posts' => $this->items(),
        ])->layout($this->layout, [
            'title' => $this->title,
        ]);
    }
}
