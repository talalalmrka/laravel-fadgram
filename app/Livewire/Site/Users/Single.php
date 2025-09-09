<?php

namespace App\Livewire\Site\Users;

use App\Models\User;
use App\Traits\WithToggleFavorite;
use Livewire\Component;

class Single extends Component
{
    use WithToggleFavorite;
    public User $user;
    public $posts;
    public $quotes;
    public $books;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->posts = $this->user->posts;
        $this->quotes = $this->user->quotes;
        $this->books = $this->user->books;
    }
    public function render()
    {
        return view('livewire.site.users.single')->layout('layouts.curve', [
            'title' => $this->user->display_name,
            'seo_title' => $this->user->seo_title,
            'seo_description' => $this->user->seo_description,
        ]);
    }
}
