<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Traits\WithToast;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use WithToast;
    public $menu_id;
    public ?Menu $menu = null;

    public function mount()
    {
        $this->loadMenuId();
        $this->loadMenu();
    }
    public function loadMenuId()
    {
        $menu = Menu::first();
        if ($menu) {
            $this->menu_id = $menu->id;
        }
    }
    public function loadMenu()
    {
        $this->menu = Menu::find($this->menu_id);
        $this->dispatch('menu-updated', id: $this->menu_id);
    }
    public function dispatchUpdated() {}
    public function updatedMenuId($value)
    {
        $this->loadMenu();
    }
    #[On('menu-created')]
    public function onMenuCreated($id)
    {
        $this->menu_id = $id;
        $this->loadMenu();
    }
    #[On('menu-deleted')]
    public function onMenuDeleted($id)
    {
        //dd($id);
        if ($id === $this->menu_id) {
            $this->toastInfo(__('Deleted :id', ['id' => $id]));
            $this->menu = null;
            $this->loadMenuId();
            $this->loadMenu();
        }
    }
    public function render()
    {
        return view('livewire.dashboard.menus.index', [
            'menu_options' => menu_options(__('Select menu')),
        ])->layout('layouts.dashboard', [
            'title' => __('Menus'),
        ]);
    }
}
