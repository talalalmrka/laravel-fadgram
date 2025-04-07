<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Menu;
use App\Traits\WithToast;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Settings extends Component
{
    use WithToast;
    public ?Menu $menu;
    public $name = '';
    public $position = '';
    public $class_name = '';
    public function mount(?Menu $menu)
    {
        $this->authorize('manage_menus');
        $this->menu = $menu;
        $this->fill($this->menu->only(['name', 'position', 'class_name']));
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', Rule::in(menu_positions())],
            'class_name' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function delete()
    {
        $this->authorize('manage_menus');
        $id = $this->menu->id;
        //$this->dispatch('menu-deleted', $id);
        $delete = $this->menu->delete();
        if ($delete) {
            $this->dispatch('menu-deleted', id: $id);
            $this->addSuccess('status', __('Delete succeed'));
        } else {
            $this->addError('status', __('Delete failed'));
        }
    }
    public function save()
    {
        $this->authorize('manage_menus');
        $this->validate();
        $this->menu->fill($this->only(['name', 'position', 'class_name']));
        $save = $this->menu->save();
        if ($save) {
            $this->addSuccess('status', __('Saved'));
        } else {
            $this->addError('status', __('Save failed'));
        }
    }
    #[On('menu-updated')]
    public function onMenuUpdated($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            $this->mount($menu);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.menus.settings');
    }
}
