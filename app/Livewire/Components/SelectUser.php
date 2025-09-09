<?php

namespace App\Livewire\Components;

use App\Models\User;
use App\Option;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class SelectUser extends Component
{
    public $id = '';
    public $label = null;
    public $icon = null;
    public $required = false;
    #[Modelable]
    public $value;
    public $error = null;
    public $info = null;
    public $placeholder = 'Select user';
    public $notIn = null;
    public $search = '';
    public $searchCols = [
        'name',
    ];
    public $limit = 10;
    public function query()
    {
        $query = User::query();
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
    public function resolveUserIds($users): array
    {
        if ($users instanceof Collection) {
            return $users->pluck('id')->all();
        }

        if ($users instanceof User) {
            return [$users->id];
        }

        if (is_array($users)) {
            $users = array_filter(Arr::flatten($users));
            return User::whereIn('name', $users)
                ->orWhereIn('id', $users)
                ->pluck('id')
                ->all();
        }

        return [User::where('name', $users)->orWhere('id', $users)->value('id')];
    }
    public function optionLabel(User $user)
    {
        $label = $user->display_name;
        return $label;
    }
    public function options()
    {
        return $this->query()->limit($this->limit)->get()->map(fn(User $user) => Option::make([
            'label' => $this->optionLabel($user),
            'value' => $user->id,
            'selected' => $user->id === $this->value,
        ]))->toArray();
    }
    public function selectedLabel()
    {
        return $this->value ? User::find($this->value)->display_name : $this->placeholder;
    }
    public function render()
    {
        return view('livewire.components.select-user', [
            'selectedLabel' => $this->selectedLabel(),
            'options' => $this->options(),
        ]);
    }
}
