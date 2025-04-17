<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class MenuController extends Controller
{
    public function index(Request $request, ?Menu $menu = null): Response
    {

        $menus = Menu::with('items.children')->get()->toArray();
        return Inertia::render('MenuBuilder', [
            'menus' => $menus,
            'menu' => $menu,
            'menu_position_options' => menu_position_options(),
            'create_status' => $request->session()->get('create_status'),
            'update_status' => $request->session()->get('update_status'),
            'status' => $request->session()->get('status'),
        ])->rootView('layouts.dashboard-inertia')->withViewData([
            'title' => __('Menus'),
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
            return redirect()->to(route('dashboard.menus.builder', $menu))->with('create_status', __('Menu created'));
        } else {
            return back()->withErrors(['create_status' => __('Create menu failed!')]);
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
            return back()->with('update_status', __('Saved'));
        } else {
            return back()->withErrors(['update_status', __('Update failed!')]);
        }
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
