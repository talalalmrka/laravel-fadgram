<?php

namespace App\Livewire\Site;

use App\Models\Author;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Test extends Component
{
    public $author_id = 13;
    public Author|null $author;
    public function mount()
    {
        $this->initAuthor();
    }
    public function updatedAuthorId()
    {
        $this->initAuthor();
    }
    public function initAuthor()
    {
        $this->author = Author::find($this->author_id);
    }
    public function rules()
    {
        return [
            'author_id' => ['required', Rule::exists('authors', 'id')],
        ];
    }
    public function updated($property)
    {
        $this->validateOnly($property);
    }
    public function render()
    {
        return view('livewire.site.test', [
            'selectedAuthor' => $this->author ? [
                'label' => $this->author->name,
                'value' => $this->author->id,
            ] : null,
        ])->layout('layouts.curve', [
            'title' => __('Test components')
        ]);
    }
}
