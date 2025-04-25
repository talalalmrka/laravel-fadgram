<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuAddCategoriesRequest;
use App\Http\Requests\MenuAddCustomLinkRequest;
use App\Http\Requests\MenuAddPagesRequest;
use App\Http\Requests\MenuAddPostsRequest;
use App\Http\Requests\MenuUpdateItemsRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class MenuController extends Controller
{
    public function index(Request $request, ?Menu $menu = null): Response
    {
        return Inertia::render('menus/Index', [
            'menus' => Menu::all()->toArray(),
            'menu' => $menu,
            'positions' => menu_position_options(),
            'pages' => fn() => Page::all()->toArray(),
            'posts' => fn() => Post::all()->toArray(),
            'categories' => fn() => Category::category()->with('children')->get()->toArray(),
            'item_types' => menu_item_type_options(),
            'items' => fn() => $menu ? $menu->items()->with('children')->get()->toArray() : [],
            //'items' => $menu ? $menu->items()->with('children')->get()->toArray() : [],
            //'menu_position_options' => menu_position_options(),
            //'create_status' => $request->session()->get('create_status'),
            //'update_status' => $request->session()->get('update_status'),
            //'status' => $request->session()->get('status'),
            //'page_options' => page_options(),
            //'add_pages_status' => $request->session()->get('add_pages_status'),
            //'post_options' => post_options(),
            //'add_posts_status' => $request->session()->get('add_posts_status'),
            //'category_options' => category_options(),
            //'add_categories_status' => $request->session()->get('add_categories_status'),
            //'menu_item_type_options' => menu_item_type_options(),
            //'add_custom_link_status' => $request->session()->get('add_custom_link_status'),
        ])->withViewData([
            'title' => $menu ? __('Edit menu :name', ['name' => $menu->name]) : __('Menus'),
            //'title' => __('Edit menu :name', ['name' => $menu?->name])
        ]);
    }

    public function test()
    {
        return view('dashboard.menus.index', [
            'menus' => Menu::paginate(),
        ]);
    }
    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create($request->validated());
        if ($menu) {
            return redirect()->to(route('dashboard.menus.builder', $menu))->with('create_menu', __('Menu created'));
        } else {
            return back()->withErrors(['create_menu' => __('Create menu failed!')]);
        }
    }
    public function edit(Menu $menu)
    {
        return view('dashboard.menus.edit', [
            'menu' => $menu,
            'title' => __('Edit menu :name', ['name' => $menu->name]),
        ]);
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->fill($request->validated());
        if ($menu->save()) {
            return back()->with('update_menu', __('Saved'));
        } else {
            return back()->withErrors(['update_menu', __('Update failed!')]);
        }
    }
    public function addPages(MenuAddPagesRequest $request, Menu $menu)
    {
        try {
            foreach ($request->pages as $pageId) {
                $page = Page::find($pageId);
                if ($page) {
                    $menu->items()->create([
                        'name' => $page->name,
                        'type' => 'page',
                        'page_id' => $page->id,
                    ]);
                }
            }
            return back()->with('add_pages', __('Pages added'));
        } catch (\Exception $e) {
            return back()->withErrors(['add_pages' => $e->getMessage()]);
        }
    }
    public function addPosts(MenuAddPostsRequest $request, Menu $menu)
    {
        try {
            foreach ($request->posts as $postId) {
                $post = Post::find($postId);
                if ($post) {
                    $menu->items()->create([
                        'name' => $post->name,
                        'type' => 'post',
                        'post_id' => $post->id,
                    ]);
                }
            }
            return back()->with('add_posts', __('Posts added'));
        } catch (\Exception $e) {
            return back()->withErrors(['add_posts' => $e->getMessage()]);
        }
    }
    public function addCategories(MenuAddCategoriesRequest $request, Menu $menu)
    {
        try {
            foreach ($request->categories as $categoryId) {
                $category = Category::find($categoryId);
                if ($category) {
                    $menu->items()->create([
                        'name' => $category->name,
                        'type' => 'category',
                        'category_id' => $category->id,
                    ]);
                }
            }
            return back()->with('add_categories', __('Categories added'));
        } catch (\Exception $e) {
            return back()->withErrors(['add_categories' => $e->getMessage()]);
        }
    }
    public function addCustomLink(MenuAddCustomLinkRequest $request, Menu $menu)
    {
        $create = $menu->items()->create(array_merge($request->validated(), [
            'type' => 'custom'
        ]));
        if ($create) {
            return back()->with('add_custom_link', __('Link added'));
        } else {
            return back()->withErrors('add_custom_link', __('Add link failed!'));
        }
    }
    public function updateItems(MenuUpdateItemsRequest $request, Menu $menu)
    {
        $items = $this->normalizeItems($request->validated());
        return response()->json($items);
        $menu->update([
            'items' => $this->normalizeItems($request->validated()),
        ]);

        return back()->with('update_items', 'Menu updated successfully');
    }
    public function updatee(Menu $menu, Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|string',
            'items.*.name' => 'required|string|max:255',
            'items.*.url' => 'nullable|string|max:255',
            'items.*.type' => 'required|in:custom,page,category,post',
            'items.*.parent_id' => 'nullable|string',
            'items.*.order' => 'required|integer',
        ]);

        $menu->update([
            'items' => $this->normalizeItems($request->items)
        ]);

        return back()->with('success', 'Menu updated successfully');
    }

    private function normalizeItems(array $items, string|null $parentId = null): array
    {
        return collect($items)->map(function ($item, $index) use ($parentId) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'url' => $item['url'] ?? null,
                'type' => $item['type'],
                'parent_id' => $parentId,
                'order' => $index,
                'children' => isset($item['children'])
                    ? $this->normalizeItems($item['children'], $item['id'])
                    : []
            ];
        })->toArray();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        if (!auth()->user()->can('manage_menus')) {
            abort(403);
        }
        $delete = $menu->delete();
        if ($delete) {
            return to_route('dashboard.menus.builder')->with('status', __('Delete success'));
        } else {
            return back()->withErrors(['delete_status', __('An error occurred while deleting the menu')]);
        }
    }
}
