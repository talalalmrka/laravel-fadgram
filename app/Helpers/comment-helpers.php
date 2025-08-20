<?php
if (!function_exists('comments_sort_options')) {
    function comments_sort_options()
    {
        return [
            [
                'label' => __('Newest top'),
                'value' => 'newest',
            ],
            [
                'label' => __('Oldest top'),
                'value' => 'oldest',
            ],
            [
                'label' => __('Popular'),
                'value' => 'Popular',
            ],
        ];
    }
}

if (!function_exists('comments_sort_values')) {
    function comments_sort_values()
    {
        return arr_map(comments_sort_options(), fn($option) => data_get($option, 'value'));
    }
}
