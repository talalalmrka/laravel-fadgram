<?php

use App\Models\Menu;

if (!function_exists('menu')) {
    function menu($id)
    {
        return Menu::find($id);
    }
}
if (!function_exists('menu_options')) {
    function menu_options($emptyOption = null)
    {
        $options = collect([]);
        if ($emptyOption) {
            $options->push([
                'label' => $emptyOption,
                'value' => '',
            ]);
        }
        $menus = Menu::all();
        $menus->each(function (Menu $menu) use ($options) {
            $options->push([
                'label' => $menu->name,
                'value' => $menu->id,
            ]);
        });
        return $options->toArray();
    }
}
if (!function_exists('menu_positions')) {
    function menu_positions()
    {
        return config('menu.positions', []);
    }
}
if (!function_exists('menu_position_options')) {
    function menu_position_options($emptyOption = null): array
    {
        $options = collect([]);
        if ($emptyOption) {
            $options->push([
                'label' => $emptyOption,
                'value' => '',
            ]);
        }
        foreach (menu_positions() as $position) {
            $label = ucfirst($position);
            $options->push([
                'label' => __("$label"),
                'value' => $position,
            ]);
        }
        return $options->toArray();
    }
}
