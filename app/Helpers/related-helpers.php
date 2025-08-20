<?php

if (!function_exists('related_query_options')) {
    function related_query_options()
    {
        return [
            [
                'label' => __('From same category'),
                'value' => 'category',
            ],
            [
                'label' => __('With same tag'),
                'value' => 'tag',
            ],
            [
                'label' => __('By the same author'),
                'value' => 'author',
            ],
            [
                'label' => __('Random'),
                'value' => 'random',
            ],
        ];
    }
}

if (!function_exists('related_query_values')) {
    function related_query_values()
    {
        return arr_map(related_query_options(), fn($option) => data_get($option, 'value'));
    }
}
