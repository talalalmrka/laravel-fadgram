<?php

namespace App\Livewire\Components;

use App\Models\Quote;
use App\Option;
use Livewire\Attributes\Modelable;
use Livewire\Component;


class SelectQuote extends Component
{
    public $id = '';
    public $label = null;
    public $icon = null;
    public $required = false;
    #[Modelable]
    public $value;
    public $error = null;
    public $info = null;
    public $placeholder = 'Select quote';
    public $category = null;
    public $search = '';
    public $searchCols = [
        'name',
        'slug',
        'content'
    ];
    public $limit = 10;
    public function query()
    {
        $query = Quote::status('publish');
        if ($this->category) {
            $query->category($this->category);
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
    public function options()
    {
        return $this->query()->limit($this->limit)->get()->map(fn(Quote $quote) => Option::make([
            'label' => $quote->name,
            'value' => $quote->id,
            'selected' => $quote->id === $this->value,
        ]))->toArray();
    }
    public function selectedLabel()
    {
        return $this->value ? Quote::find($this->value)->name : $this->placeholder;
    }
    public function render()
    {
        return view('livewire.components.select-quote', [
            'selectedLabel' => $this->selectedLabel(),
            'options' => $this->options(),
        ]);
    }
}
