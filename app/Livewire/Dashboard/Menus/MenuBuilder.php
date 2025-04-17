<?php

namespace App\Livewire\Dashboard\Menus;

use Livewire\Component;
use App\Models\Menu;
use App\Models\MenuItem;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;

class MenuBuilder extends Component
{
    #[Session]
    public $menu_id;
    public ?Menu $menu = null;
    public $items = [];

    public function mount()
    {
        $this->loadMenu();
    }
    public function loadMenu()
    {
        $this->menu = Menu::find($this->menu_id);
        $this->loadItems();
    }
    public function updatedMenuId()
    {
        $this->loadMenu();
    }
    public function loadItems()
    {
        if ($this->menu) {
            $this->items = $this->menu->items()->with('children')->get();
        }
    }
    #[On('save-items')]
    public function onSave($items)
    {
        dd($items);
    }
    public function render()
    {
        return view('livewire.dashboard.menus.menu-builder', [
            'inertiaPage' => [
                'component' => 'Menus/Edit',
                'props' => [
                    'menu' => $this->menu,
                    'items' => $this->items,
                ],
            ]
        ])->layout('layouts.dashboard', [
            'title' => $this->menu ? $this->menu->name : __('Menus'),
        ]);
    }
}
