<?php
if (!function_exists('sorts')) {
    function sorts()
    {
        return [
            'newest' => [
                'field' => 'id',
                'direction' => 'desc',
                'label' => __('Newest top'),
            ],
            'oldest' => [
                'field' => 'id',
                'direction' => 'asc',
                'label' => __('Oldest top'),
            ],
            'az' => [
                'field' => 'name',
                'direction' => 'asc',
                'label' => __('A → Z'),
            ],
            'za' => [
                'field' => 'name',
                'direction' => 'desc',
                'label' => __('Z → A'),
            ],
            'popular' => [
                'field' => 'meta.views',
                'direction' => 'desc',
                'label' => __('Popular'),
            ],
        ];
    }
}
if (!function_exists('sort_label')) {
    function sort_label($id)
    {
        return data_get(sorts(), "$id.label");
    }
}
if (!function_exists('sort_field')) {
    function sort_field($id)
    {
        return data_get(sorts(), "$id.field");
    }
}
if (!function_exists('sort_direction')) {
    function sort_direction($id)
    {
        return data_get(sorts(), "$id.direction");
    }
}
if (!function_exists('sort_options')) {
    function sort_options()
    {
        return arr_map(array_keys(sorts()), fn($sort) => ['label' => sort_label($sort), 'value' => $sort]);
    }
}
if (!function_exists('sort_values')) {
    function sort_values()
    {
        return array_keys(sorts());
    }
}
