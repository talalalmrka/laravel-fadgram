<?php
if (!function_exists('template_options')) {
    function template_options()
    {
        return [
            [
                'label' => __('Default'),
                'value' => 'default',
            ],
            [
                'label' => __('Cover'),
                'value' => 'cover',
            ],
            [
                'label' => __('Curve'),
                'value' => 'curve',
            ],
        ];
    }
}

if (!function_exists('templates')) {
    function templates()
    {
        return arr_map(template_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}
