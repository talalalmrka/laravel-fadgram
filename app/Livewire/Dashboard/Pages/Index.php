<?php

namespace App\Livewire\Dashboard\Pages;

use App\Livewire\Dashboard\Posts\Index as PostsIndex;

use App\Models\Post;

class Index extends PostsIndex
{
    public $id_column = true;
    public function builder()
    {
        $query = Post::type('page');
        if (!empty($this->user_id)) {
            $query->where('user_id', $this->user_id);
        }
        if (!empty($this->category_id)) {
            $query->category($this->category_id);
        }
        if (!empty($this->publish_status)) {
            $query->status($this->publish_status);
        }
        return $query;
    }
    public function create()
    {
        $this->redirect(route('dashboard.pages.create'));
    }
    public function render()
    {
        return view('livewire.dashboard.posts.index')->layout('layouts.dashboard', [
            'title' => __('Pages'),
        ]);
    }
}
