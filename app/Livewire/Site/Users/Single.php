<?php

namespace App\Livewire\Site\Users;

use App\Models\User;
use Livewire\Component;

class Single extends Component
{
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
            'title' => __(get_option('user_title', 'User: :name'), ['name' => $this->user->name]),
        ]);
    }
}
