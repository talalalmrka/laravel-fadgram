<?php

namespace App\Livewire\Site\Posts;

use App\Models\Post;
use Livewire\Component;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToggleFavorite;

class Single extends Component
{
    use WithDownloadQuoteDialog, WithToggleFavorite;
    public Post $post;
    public $editPermission;
    public $editUrl;
    public $related;
    public $relatedLabel;
    public function mount(Post $post)
    {
        $this->post = $post;
        $this->related = (bool) get_option('related_posts_enabled', false) ? $this->post->related() : null;
        $this->relatedLabel = get_option('related_posts_label');
    }
    public function render()
    {
        if ($this->post->type === 'page') {
            if ((bool) $this->post->getMeta('builder_enabled')) {
                return view('livewire.site.posts.builder', [
                    'blocks' => $this->post->blocks,
                ])->layout('layouts.default', [
                    'title' => $this->post->name,
                    'seo_title' => $this->post->seo_title,
                    'seo_description' => $this->post->seo_description,
                    'navbarclass' => 'navbar-transparent-top navbar-transparent-primary fixed top-0 start-0 end-0 z-40',
                ]);
            } else {
                return view('livewire.site.posts.page')->layout('layouts.curve', [
                    'title' => $this->post->name,
                    'seo_title' => $this->post->seo_title,
                    'seo_description' => $this->post->seo_description,
                ]);
            }
        }

        return view('livewire.site.posts.single')->layout($this->post->layout, [
            'title' => $this->post->name,
            'seo_title' => $this->post->seo_title,
            'seo_description' => $this->post->seo_description,
        ]);
    }
}
