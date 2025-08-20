<?php

namespace App\Livewire\Dashboard\Pages;

use App\Livewire\Dashboard\Posts\Edit as EditPost;
use App\Models\Post;

class Edit extends EditPost
{
    public $type = 'page';
    public function createTitle()
    {
        return __('Create page');
    }
    public function editTitle()
    {
        return __('Edit page :name', ['name' => $this->name]);
    }
    public function beforeSave()
    {
        if (empty($this->slug)) {
            $this->slug = Post::generateSlug($this->name);
        }
        if (empty($this->user_id)) {
            $this->user_id = auth()->user()->id;
        }
    }
    public function afterSave()
    {
        $this->post->syncCategories($this->categories);
        $this->post->syncTags($this->tags);
        if ($this->editUrl !== $this->post->edit_url) {
            $this->redirect($this->post->edit_url, true);
        }
    }
    public function statusKey()
    {
        return 'save';
    }

    public function pageBuilder()
    {
        $this->post->updateMeta('builder_enabled', 1);
        return $this->redirect($this->post->edit_url);
    }
}
