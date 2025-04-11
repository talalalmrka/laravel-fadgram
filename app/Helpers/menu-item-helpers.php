<?php

use Illuminate\Support\Arr;

if (!function_exists('menu_item_types')) {
    function menu_item_types()
    {
        return ['custom', 'post', 'page', 'category'];
    }
}

if (!function_exists('menu_item_type_options')) {
    function menu_item_type_options()
    {
        return Arr::map(menu_item_types(), function ($type) {
            return [
                'label' => __("$type"),
                'value' => $type,
            ];
        });
    }
}
