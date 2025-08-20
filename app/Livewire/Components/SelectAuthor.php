<?php

namespace App\Livewire\Components;

use App\Models\Author;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SelectAuthor extends Component
{
    #[Modelable]
    public $value = null;
    public Author|null $author = null;
    public $search = null;
    public $placeholder;
    public function render()
    {
        return view('livewire.components.select-author');
    }
}
