<?php
if (!function_exists('media_collection_names')) {
    function media_collection_names($model)
    {
        return $model && method_exists($model, 'getRegisteredMediaCollections') ? array_keys($model->getRegisteredMediaCollections()->toArray()) : [];
    }
}
if (!function_exists('media_collection_name_options')) {
    function media_collection_name_options($model)
    {
        $options = [
            [
                'label' => __('Default'),
                'value' => 'default',
            ],
        ];
        $collections = $model && method_exists($model, 'getRegisteredMediaCollections') ? $model->getRegisteredMediaCollections() : null;
        if ($collections && $collections->isNotEmpty()) {
            foreach ($collections as $name => $collection) {
                $options[] = [
                    'label' => __("$name"),
                    'value' => $name,
                ];
            }
        }
        return $options;
    }
}

if (!function_exists('model_icon')) {
    function model_icon($model, $plural = false)
    {
        $table = $model->getTable();
        if ($plural) {
            return config("icons.$table");
        } else {
            return config("icons.{str()->singular($table)}");
        }
    }
}

if (!function_exists('model_label')) {
    function model_label($model, $plural = false)
    {
        $label = $plural ? ucfirst($model->getTable()) : ucfirst(str()->singular($model->getTable()));
        $label = __("$label");
    }
}

if (!function_exists('model_link')) {
    function model_link($model, $data = [])
    {
        $defaults = [
            'class' => 'link flex-space-1',
            'atts' => [],
            'iconClass' => '',
            'target' => '_blank',
        ];
        $data = array_merge($defaults, $data);
        extract($data);
        $single = str()->singular($model->getTable());
        $name = $model->display_name ?? $model->name ?? $model->title ?? $model->{$model->fillable[1]};
        $label = $name ? "<span>$name</span>" : $name;
        $icon = config("icons.$single");
        $icon = $icon ? "<i class=\"icon $icon $iconClass\"></i>" : '';
        return $model->permalink ? "<a class=\"$class\" target=\"$target\" href=\"{$model->permalink}\" title=\"$name\">{$icon}{$label}</a>" : $icon . $label;
    }
}
