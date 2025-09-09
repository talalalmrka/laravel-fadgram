<?php

namespace App\Livewire\Components;

use App\Models\Author;
use App\Option;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class SelectAuthor extends Component
{
    public $id = '';
    public $label = null;
    public $icon = null;
    public $required = false;
    #[Modelable]
    public $value;
    public $error = null;
    public $info = null;
    public $placeholder = 'Select author';
    public $notIn = null;
    public $search = '';
    public $searchCols = [
        'name',
        'content',
        'slug',
    ];
    public $limit = 10;
    public function query()
    {
        $query = Author::query();
        if ($this->notIn) {
            $query->whereNotIn('id', $this->resolveAuthorIds($this->notIn));
        }
        if ($this->search) {
            $query->where(function ($q) {
                foreach ($this->searchCols as $col) {
                    $q->orWhere($col, 'like', "%{$this->search}%");
                }
            });
        }
        return $query;
    }
    public function resolveAuthorIds($authors): array
    {
        if ($authors instanceof Collection) {
            return $authors->pluck('id')->all();
        }

        if ($authors instanceof Author) {
            return [$authors->id];
        }

        if (is_array($authors)) {
            $authors = array_filter(Arr::flatten($authors));
            return Author::whereIn('name', $authors)
                ->orWhereIn('id', $authors)
                ->pluck('id')
                ->all();
        }

        return [Author::where('name', $authors)->orWhere('id', $authors)->value('id')];
    }
    public function optionLabel(Author $author)
    {
        $label = $author->name;
        return $label;
    }
    public function options()
    {
        return $this->query()->limit($this->limit)->get()->map(fn(Author $author) => Option::make([
            'label' => $this->optionLabel($author),
            'value' => $author->id,
            'selected' => $author->id === $this->value,
        ]))->toArray();
    }
    public function selectedLabel()
    {
        return $this->value ? Author::find($this->value)->name : $this->placeholder;
    }
    public function render()
    {
        return view('livewire.components.select-author', [
            'selectedLabel' => $this->selectedLabel(),
            'options' => $this->options(),
        ]);
    }
}
