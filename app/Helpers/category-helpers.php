<?php

use App\Models\Category;
use Illuminate\Support\Arr;

if (!function_exists('category')) {
    function category($id)
    {
        return Category::find($id);
    }
}
if (!function_exists('instance_category')) {
    function instance_category($object)
    {
        return $object instanceof Category;
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
    function get_categories($options = [])
    {
        $ops = collect($options);
        $query = Category::where('type', 'category');

        // users
        $users = $ops->get('users');
        if ($users && !empty($users)) {
            $query->withUser($users);
        }

        $sort = $ops->get('sort');
        if ($sort) {
            $field = sort_field($sort);
            $direction = sort_direction($sort);

            if ($field && $direction) {
                $query->orderBy($field, $direction);
            }
        }
        $limit = $ops->get('limit');
        if ($limit && !empty($limit)) {
            return $query->take($limit)->get();
        }

        $per_page = $ops->get('per_page', get_option('posts_per_page', 10));
        return $query->paginate($per_page);
    }
}

if (!function_exists('category_choices_options')) {
    function category_choices_options($selected = [])
    {
        $cats = Category::type('category')->get();
        $options = $cats->map(function (Category $tag) use ($selected) {
            return [
                'label' => $tag->name,
                'value' => $tag->id,
                'selected' => in_array($tag->id, array_values($selected))
            ];
        })->toArray();
        return $options;
    }
}
