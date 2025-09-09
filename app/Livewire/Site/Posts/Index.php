<?php

namespace App\Livewire\Site\Posts;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Post;
use App\Traits\WithToast;
use App\Traits\WithToggleFavorite;

class Index extends ArchivePage
{
    use WithToggleFavorite;
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
    public function render()
    {
        return view('livewire.site.posts.index', [
            'posts' => $this->items(),
        ])->layout($this->layout, [
            'title' => $this->title,
        ]);
    }
}
