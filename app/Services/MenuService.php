<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MenuService
{
    public function updateItems(Menu $menu, array $items): bool
    {
        try {
            DB::transaction(function () use ($menu, $items) {
                $this->deleteMissing($menu, $items);
                foreach ($items as $order => $itemData) {
                    $this->upsertMenuItem($menu, null, $itemData, $order);
                }
            });
            return true;
        } catch (\Exception $e) {
            Log::error('Menu items update failed: ' . $e->getMessage(), [
                'menu_id' => $menu->id,
                'exception' => $e
            ]);
            return false;
        }
    }
    protected function collectIds(array $items)
    {
        $ids = [];
        foreach ($items as $item) {
            $id = data_get($item, 'id');
            if ($id) {
                $ids[] = $id;
            }
            $children = data_get($item, 'children');
            if (!empty($children)) {
                $ids = [
                    ...$ids,
                    ...$this->collectIds($children),
                ];
            }
        }
        return $ids;
    }
    protected function deleteMissing(Menu $menu, array $items)
    {
        $existingIds = MenuItem::where('menu_id', $menu->id)->pluck('id')->toArray();
        $newIds = $this->collectIds($items);
        $idsToDelete = array_diff($existingIds, $newIds);
        if (!empty($idsToDelete)) {
            MenuItem::destroy(array_values($idsToDelete));
        }
    }
    protected function upsertMenuItem(Menu $menu, ?int $parentId, array $itemData, int $order)
    {
        $children = data_get($itemData, 'children', []);
        unset($itemData['children']);
        $id = data_get($itemData, 'id');
        $item = MenuItem::find($id);
        if ($item) {
            $item->update([
                ...$itemData,
                'parent_id' => $parentId,
                'order' => $order
            ]);
            if (!empty($children)) {
                foreach ($children as $order => $childData) {
                    $this->upsertMenuItem($menu, $item->id, $childData, $order);
                }
            }
        }
    }

    public function normalizeItems(array $items, string|null $parentId = null): array
    {
        return collect($items)->map(function ($item, $index) use ($parentId) {
            return array_merge($item, [
                'parent_id' => $parentId,
                'order' => $index,
                'children' => isset($item['children'])
                    ? $this->normalizeItems($item['children'], $item['id'])
                    : []
            ]);
        })->toArray();
    }
}
