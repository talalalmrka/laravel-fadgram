<?php

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Arr;

if (!function_exists('tag')) {
    function tag($id)
    {
        return Category::type('tag')->find($id);
    }
}
if (!function_exists('tag_options')) {
    function tag_options($selected = [])
    {
        $tags = Category::type('tag')->get();
        $options = $tags->map(function (Category $tag) use ($selected) {
            return [
                'label' => $tag->name,
                'value' => $tag->id,
                'selected' => in_array($tag->id, array_values($selected))
            ];
        })->toArray();
        return $options;
    }
}
