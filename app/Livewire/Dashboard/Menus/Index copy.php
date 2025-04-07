<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Menu;
use App\Models\MenuItem;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Collection;

class Index extends Component
{
    public Collection $menus;
    public ?Menu $selectedMenu = null;
    public string $newMenuName = '';

    public $menuSettings = [
        'name' => '',
        'position' => '',
        'class_name' => '',
        'description' => '',
    ];

    public $menuItems = [];

    public $customLink = [
        'name' => '',
        'url' => '',
        'icon' => '',
        'target' => '_self',
    ];

    public function mount()
    {
        $this->menus = Menu::all();
    }

    public function selectMenu($menuId)
    {
        $this->selectedMenu = Menu::find($menuId);
        $this->menuSettings = $this->selectedMenu->only(['name', 'position', 'class_name', 'description']);
        $this->loadMenuItems();
    }

    public function loadMenuItems()
    {
        $this->menuItems = $this->buildTree($this->selectedMenu->items()->with('children')->get());
    }

    public function createMenu()
    {
        $this->validate([
            'newMenuName' => 'required|string|max:255',
        ]);

        $menu = Menu::create(['name' => $this->newMenuName]);
        $this->menus = Menu::all();
        $this->selectMenu($menu->id);
        $this->newMenuName = '';
    }

    public function saveMenuSettings()
    {
        $this->selectedMenu->update($this->menuSettings);
        session()->flash('success', 'Menu settings saved.');
    }

    public function deleteMenu()
    {
        $this->selectedMenu->delete();
        $this->selectedMenu = null;
        $this->menus = Menu::all();
        $this->menuItems = [];
    }

    public function addCustomLink()
    {
        $this->validate([
            'customLink.name' => 'required|string|max:255',
            'customLink.url' => 'required|url',
        ]);

        $this->selectedMenu->items()->create([
            'name' => $this->customLink['name'],
            'url' => $this->customLink['url'],
            'type' => 'custom',
            'icon' => $this->customLink['icon'] ?? '',
            'target' => $this->customLink['target'],
        ]);

        $this->customLink = ['name' => '', 'url' => '', 'icon' => '', 'target' => '_self'];
        $this->loadMenuItems();
    }

    public function updateMenuStructure($items)
    {
        $this->updateItemOrder($items);
        $this->loadMenuItems();
    }

    protected function updateItemOrder($items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            MenuItem::where('id', $item['id'])->update([
                'order' => $index + 1,
                'parent_id' => $parentId
            ]);

            if (isset($item['children'])) {
                $this->updateItemOrder($item['children'], $item['id']);
            }
        }
    }

    public function buildTree($items)
    {
        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'icon' => $item->icon,
                'type' => $item->type,
                'children' => $item->children->count() ? $this->buildTree($item->children) : []
            ];
        })->toArray();
    }
    public function render()
    {
        return view('livewire.dashboard.menus.index')->layout('layouts.dashboard', [
            'title' => __('Menus'),
        ]);
    }
}
