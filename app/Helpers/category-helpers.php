<?php

use App\Models\Category;
use Illuminate\Support\Arr;

if (!function_exists('category')) {
    function category($id)
    {
        return Category::find($id);
    }
}
if (!function_exists('category_option')) {
    function category_option($category, $level = 0) {}
}
if (!function_exists('category_options')) {
    function category_options($emptyOption = null, $parentId = null, $level = 0, $excludeId = null)
    {
        $options = [];
        if ($emptyOption) {
            $options[] = [
                'label' => $emptyOption,
                'value' => '',
            ];
        }
        $categories = Category::category()->where('parent_id', $parentId)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->orderBy('name')
            ->get();

        foreach ($categories as $category) {
            $options[] = [
                'label' => str_repeat('&nbsp;', $level * 4) . $category->name,
                'value' => $category->id,
            ];

            $children = category_options(null, $category->id, $level + 1, $excludeId);
            $options = array_merge($options, $children);
        }

        return $options;
    }
}

if (!function_exists('parent_category_options')) {
    function parent_category_options($id, $emptyOption = null)
    {
        return array_filter(category_options($emptyOption), function ($option) use ($id) {
            return $option['value'] !== $id;
        });
    }
}

if (!function_exists('categories')) {
    function categories()
    {
        return Category::type('category');
    }
}

if (!function_exists('get_categories')) {
    function get_categories($data = [])
    {
        $query = Category::type('category');
        $parent_id = data_get($data, 'parent_id');
        if (empty($parent_id)) {
            $parent_id = null;
        }
        if ($parent_id !== 'all') {
            $query->where('parent_id', $parent_id);
        }
        $sortField = data_get($data, 'sortField', 'id');
        $sortDirection = data_get($data, 'sortDirection', 'asc');
        if ($sortField && $sortDirection) {
            $query->orderBy($sortField, $sortDirection);
        }
        $limit = data_get($data, 'limit');
        if ($limit) {
            return $query->limit($limit)->get();
        }
        $perPage = data_get($data, 'perPage');
        return $query->paginate($perPage);
    }
}
