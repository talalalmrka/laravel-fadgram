<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Menu;
use App\Traits\WithToast;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    use WithToast;
    #[Validate]
    public $name = '';
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
    public function create()
    {
        $this->authorize('manage_menus');
        $this->validate();
        $menu = Menu::create($this->only('name'));
        if ($menu) {
            $this->reset('name');
            $this->addSuccess('status', __('Menu created'));
            $this->dispatch('menu-created', id: $menu->id);
        } else {
            $this->addError('status', __('Create failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.menus.create');
    }
}
