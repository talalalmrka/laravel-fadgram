<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Menu;
use App\Traits\WithToast;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Settings extends Component
{
    use WithToast;
    public ?Menu $menu;
    public $name = '';
    public $position = '';
    public $class_name = '';
    public function mount(Menu $menu)
    {
        $this->authorize('manage_menus');
        $this->menu = $menu;
        if ($this->menu->id) {
            $this->fill($this->menu->only(['name', 'position', 'class_name']));
        } else {
            $this->reset('name', 'position', 'class_name');
        }
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
        if ($this->menu) {
            $id = $this->menu->id;
            $delete = $this->menu->delete();
            if ($delete) {
                $this->menu = new Menu;
                $this->dispatch('deleted', 'menu', $id);
                $this->toastSuccess(__('Delete succeed'));
            } else {
                $this->toastError('status', __('Delete failed'));
            }
        } else {
            $this->toastError(__('Nothing to delete!'));
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
            $this->dispatch('saved', 'menu', id: $this->menu->id);
        } else {
            $this->addError('status', __('Save failed'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.menus.settings');
    }
}
