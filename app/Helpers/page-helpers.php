<?php

use App\Models\Post;

if (!function_exists('page')) {
    function page($id)
    {
        return Post::type('page')->find($id);
    }
}
if (!function_exists('page_options')) {
    function page_options($emptyOption = true, $emptyOptionLabel = null)
    {
        $options = collect([]);
        if ($emptyOption) {
            $options->push([
                'label' => $emptyOptionLabel ?? __('Select page'),
                'value' => '',
            ]);
        }
        $pages = Post::type('page')->get();
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
