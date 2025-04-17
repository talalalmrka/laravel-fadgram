<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Traits\WithToast;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class Structure extends Component
{
    use WithToast;
    public Menu $menu;
    public ?MenuItem $editItem = null;
    public bool $showEdit = false;
    public $selectAllPages = false;
    public $pages = [];
    public $selectAllPosts = false;
    public $posts = [];
    public $selectAllCategories = false;
    public $categories = [];
    public $custom = [];
    public $items = [];
    public function mount(Menu $menu)
    {
        $this->menu = $menu;
        $this->loadItems();
    }
    public function loadItems()
    {
        //$this->items = $this->menu->items()->with('children')->get()->toArray();
        $this->items = $this->menu->items()->where('parent_id', null)->orderBy('order')->get();
    }
    public function updatedSelectAllPages($value)
    {
        if ($value) {
            $this->pages = Page::all()->pluck('id')->toArray();
        } else {
            $this->pages = [];
        }
    }
    public function updatedSelectAllPosts($value)
    {
        if ($value) {
            $this->posts = Post::all()->pluck('id')->toArray();
        } else {
            $this->posts = [];
        }
    }

    public function addPages()
    {
        $this->validate([
            'pages' => ['required', 'array'],
            'pages.*' => ['required', 'integer', Rule::exists('posts', 'id')->where('type', 'page')],
        ]);

        foreach ($this->pages as $pageId) {
            $page = Page::find($pageId);
            $this->menu->items()->create([
                'type' => 'page',
                'page_id' => $page->id,
                'name' => $page->name,
                'order' => $this->menu->items()->max('order') + 1,
            ]);
        }

        $this->reset('pages', 'selectAllPages');
        $this->loadItems();
        $this->addSuccess('pages_status', __('Added successfully.'));
    }

    public function addPosts()
    {
        $this->validate([
            'posts' => ['required', 'array'],
            'posts.*' => ['required', 'integer', Rule::exists('posts', 'id')->where('type', 'post')],
        ]);

        foreach ($this->posts as $postId) {
            $post = Post::find($postId);
            $this->menu->items()->create([
                'type' => 'post',
                'post_id' => $post->id,
                'name' => $post->name,
                'order' => $this->menu->items()->max('order') + 1,
            ]);
        }

        $this->reset('posts', 'selectAllPosts');
        $this->loadItems();
        $this->addSuccess('posts_status', __('Added successfully.'));
    }
    public function addCategories()
    {
        $this->validate([
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
        ]);

        foreach ($this->categories as $catId) {
            $category = Category::find($catId);
            $this->menu->items()->create([
                'type' => 'category',
                'post_id' => $category->id,
                'name' => $category->name,
                'order' => $this->menu->items()->max('order') + 1,
            ]);
        }

        $this->reset('categories', 'selectAllCategories');
        $this->loadItems();
        $this->addSuccess('categories_status', __('Added successfully.'));
    }

    public function addCustom()
    {
        $this->validate([
            'custom' => ['required', 'array'],
            'custom.name' => ['nullable', 'string', 'max:255'],
            'custom.icon' => ['nullable', 'string', 'max:255'],
            'custom.url' => ['nullable', 'string', 'max:255'],
        ]);
        $custom = $this->menu->items()->create([
            'type' => 'custom',
            'name' => $this->custom['name'],
            'icon' => $this->custom['icon'],
            'url' => $this->custom['url'],
            'order' => $this->menu->items()->max('order') + 1,
        ]);
        if ($custom) {
            $this->reset('custom');
            $this->loadItems();
            $this->addSuccess('custom_status', __('Added successfully.'));
        } else {
            $this->addSuccess('custom_status', __('Failed!'));
        }
    }
    /*public function updateItemOrder($itemId, $oldIndex, $oldParentId, $newIndex, $newParentId)
    {
        DB::transaction(function () use ($itemId, $oldIndex, $oldParentId, $newIndex, $newParentId) {
            $movedItem = MenuItem::findOrFail($itemId);

            // If the parent has changed
            if ($oldParentId !== $newParentId) {
                // Update the moved item's parent
                $movedItem->parent_id = $newParentId === 'null' ? null : $newParentId;
                $movedItem->order = $this->getMaxOrder($newParentId) + 1;
                $movedItem->save();

                // Reorder items in the old parent
                $this->reorderSiblings($oldParentId, $oldIndex);

                // No need to reorder in the new parent here, as the moved item's order is set to the end
            } else {
                // If the parent is the same, only the order has changed
                if ($oldIndex < $newIndex) {
                    // Moved down
                    MenuItem::where('menu_id', $this->menu->id)
                        ->where('parent_id', $newParentId === 'null' ? null : $newParentId)
                        ->where('order', '>', $oldIndex)
                        ->where('order', '<=', $newIndex)
                        ->decrement('order');
                } elseif ($oldIndex > $newIndex) {
                    // Moved up
                    MenuItem::where('menu_id', $this->menu->id)
                        ->where('parent_id', $newParentId === 'null' ? null : $newParentId)
                        ->where('order', '>=', $newIndex)
                        ->where('order', '<', $oldIndex)
                        ->increment('order');
                }

                $movedItem->order = $newIndex;
                $movedItem->save();
            }
        });

        $this->loadItems();
        $this->addSuccess('order_status', '');
        $this->js('refresh');
    }

    protected function reorderSiblings($parentId, $excludedOrder)
    {
        MenuItem::where('menu_id', $this->menu->id)
            ->where('parent_id', $parentId === 'null' ? null : $parentId)
            ->where('order', '>', $excludedOrder)
            ->decrement('order');
    }

    protected function getMaxOrder($parentId)
    {
        return MenuItem::where('menu_id', $this->menu->id)
            ->where('parent_id', $parentId === 'null' ? null : $parentId)
            ->max('order') ?? 0;
    }*/
    public function updateItemOrder($itemId, $oldIndex, $oldParentId, $newIndex, $newParentId)
    {
        DB::transaction(function () use ($itemId, $oldIndex, $oldParentId, $newIndex, $newParentId) {
            $movedItem = MenuItem::findOrFail($itemId);

            // If the parent has changed
            if ($oldParentId != $newParentId) {
                // Update the moved item's parent
                $movedItem->parent_id = $newParentId === 'null' ? null : $newParentId;
                $movedItem->order = $this->getMaxOrder($newParentId) + 1;
                $movedItem->save();

                // Reorder items in the old parent
                $this->reorderSiblings($oldParentId, $oldIndex);
            } else {
                // If the parent is the same, only the order has changed
                if ($oldIndex < $newIndex) {
                    // Moved down
                    MenuItem::where('menu_id', $this->menu->id)
                        ->where('parent_id', $newParentId === 'null' ? null : $newParentId)
                        ->where('order', '>', $oldIndex)
                        ->where('order', '<=', $newIndex)
                        ->decrement('order');
                } elseif ($oldIndex > $newIndex) {
                    // Moved up
                    MenuItem::where('menu_id', $this->menu->id)
                        ->where('parent_id', $newParentId === 'null' ? null : $newParentId)
                        ->where('order', '>=', $newIndex)
                        ->where('order', '<', $oldIndex)
                        ->increment('order');
                }

                $movedItem->order = $newIndex;
                $movedItem->save();
            }
        });
        //$this->skipRender();
        $this->loadItems();
        //$this->js('refresh'); // Trigger a client-side refresh
        $this->addSuccess('order_status', __('Saved'));
        $this->dispatch('item-order-changed');
        $this->skipRender();
    }

    protected function reorderSiblings($parentId, $excludedOrder)
    {
        MenuItem::where('menu_id', $this->menu->id)
            ->where('parent_id', $parentId === 'null' ? null : $parentId)
            ->where('order', '>', $excludedOrder)
            ->decrement('order');
    }

    protected function getMaxOrder($parentId)
    {
        return MenuItem::where('menu_id', $this->menu->id)
            ->where('parent_id', $parentId === 'null' ? null : $parentId)
            ->max('order') ?? 0;
    }
    #[On('saved')]
    public function onSaved($model_type, $id)
    {
        if ($model_type === 'menu_item') {
            $this->editItem = null;
            $this->loadItems();
        }
    }
    #[On('items-added')]
    public function onItemsAdded()
    {
        $this->loadItems();
    }
    public function edit(MenuItem $item)
    {
        $this->editItem = $item;
        $this->showEdit = true;
        //dd($item->toArray());
        //$this->dispatch('edit', 'item', $id);
    }
    #[Computed]
    public function editTitle()
    {
        return $this->editItem ? __('Edit :name', ['name' => $this->editItem->name]) : __('Edit');
    }
    public function deleteItem(MenuItem $item)
    {
        $this->authorize('manage_menus');
        $delete = $item->delete();
        if ($delete) {
            $this->toastSuccess(__('Item deleted'));
            $this->loadItems();
        } else {
            $this->toastError(__('Failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.menus.structure');
    }
}
