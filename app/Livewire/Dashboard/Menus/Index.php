<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Traits\WithToast;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;

class Index extends Component
{
    use WithToast;
    #[Session]
    public $menu_id;
    public function mount()
    {
        //$this->loadMenuId();
    }
    public function loadMenuId()
    {
        $menu = Menu::first();
        if ($menu) {
            $this->menu_id = $menu->id;
        }
    }
    #[Computed]
    public function menu()
    {
        //return Menu::find($this->menu_id) ?? new Menu;
        return Menu::find($this->menu_id) ?? null;
    }
    public function deleteMenu($id)
    {
        $this->toastInfo(__('Delete menu :id', ['id' => $id]));
    }
    #[On('created')]
    public function onCreated($model_type, $id)
    {
        if ($model_type === 'menu') {
            $this->menu_id = $id;
        }
    }
    #[On('saved')]
    public function onSaved($model_type, $id)
    {
        if ($model_type === 'menu') {
            $this->menu_id = $id;
        }
    }

    #[On('deleted')]
    public function onDeleted($model_type, $id)
    {
        if ($model_type === 'menu') {
            $this->menu_id = null;
        }
    }
    public function resetDefaults()
    {
        Menu::truncate();
        MenuItem::truncate();

        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'MenuSeeder',
        ]);
        $this->addSuccess('reset_status', __('Reset successfully'));
        $this->js('reseted');
    }
    public function render()
    {
        return view('livewire.dashboard.menus.index')->layout('layouts.dashboard', [
            'title' => __('Menus'),
        ]);
    }
}
