<?php

if (!function_exists('status_options')) {
    function status_options($emptyOption = null)
    {
        $options = [];
        if ($emptyOption) {
            $options[] = [
                'label' => $emptyOption,
                'value' => null,
            ];
        }
        return $options + [
            [
                'label' => __('Draft'),
                'value' => 'draft',
            ],
            [
                'label' => __('Publish'),
                'value' => 'publish',
            ],
            [
                'label' => __('Trash'),
                'value' => 'trash',
            ],
        ];
    }
}

if (!function_exists('status_values')) {
    function status_values()
    {
        return arr_map(status_options(), fn($option) => data_get($option, 'value'));
    }
}
