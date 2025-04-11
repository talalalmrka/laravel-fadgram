<?php

use App\Models\Page;

if (!function_exists('page')) {
    function page($id)
    {
        return Page::find($id);
    }
}
if (!function_exists('page_options')) {
    function page_options($emptyOption = null)
    {
        $options = collect([]);
        if ($emptyOption) {
            $options->push([
                'label' => $emptyOption,
                'value' => '',
            ]);
        }
        $pages = Page::all();
        if ($pages->isNotEmpty()) {
            foreach ($pages as $page) {
                $options->push([
                    'label' => $page->name,
                    'value' => $page->id,
                ]);
            }
        }
        return $options->toArray();
    }
}
