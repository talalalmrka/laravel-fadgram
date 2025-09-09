<?php

namespace App\Livewire\Components;

use App\Models\Category;
use App\Option;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class SelectCategory extends Component
{
    public $id = '';
    public $label = null;
    public $icon = null;
    public $required = false;
    #[Modelable]
    public $value;
    public $type = 'category';
    public $error = null;
    public $info = null;
    public $placeholder = 'Select category';
    public $notIn = null;
    public $search = '';
    public $searchCols = [
        'name',
        'slug',
        'description'
    ];
    public $hasQuotes = false;
    public $hasPosts = false;
    public $hasBooks = false;
    public $showCount = null;
    public $limit = 10;
    public function query()
    {
        $query = Category::type($this->type);
        if ($this->hasQuotes) {
            $query->hasQuotes();
        }
        if ($this->hasPosts) {
            $query->hasPosts();
        }
        if ($this->hasBooks) {
            $query->hasBooks();
        }
        if ($this->notIn) {
            $query->whereNotIn('id', $this->resolveCategoryIds($this->notIn));
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
    public function resolveCategoryIds($categories): array
    {
        if ($categories instanceof Collection) {
            return $categories->pluck('id')->all();
        }

        if ($categories instanceof Category) {
            return [$categories->id];
        }

        if (is_array($categories)) {
            $categories = array_filter(Arr::flatten($categories));
            return Category::whereIn('slug', $categories)
                ->orWhereIn('id', $categories)
                ->pluck('id')
                ->all();
        }

        return [Category::where('slug', $categories)->orWhere('id', $categories)->value('id')];
    }
    public function optionLabel(Category $category)
    {
        $label = $category->name;
        if ($this->showCount) {
            $count = data_get($category, $this->showCount);
            if ($count) {
                $label .= " ($count)";
            }
        }
        return $label;
    }
    public function options()
    {
        return $this->query()->limit($this->limit)->get()->map(fn(Category $category) => Option::make([
            'label' => $this->optionLabel($category),
            'value' => $category->id,
            'selected' => $category->id === $this->value,
        ]))->toArray();
    }
    public function selectedLabel()
    {
        return $this->value ? Category::find($this->value)->name : $this->placeholder;
    }
    public function render()
    {
        return view('livewire.components.select-category', [
            'selectedLabel' => $this->selectedLabel(),
            'options' => $this->options(),
        ]);
    }
}
