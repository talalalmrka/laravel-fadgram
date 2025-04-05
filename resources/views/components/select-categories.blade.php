@props([
    'id' => uniqid('select-categories-'),
    'name' => null,
    'icon' => null,
    'label' => null,
    'value' => null,
    'required' => false,
    'error' => null,
    'disabled' => false,
    'atts' => [],
    'info' => null,
    //'categories',
    'filters' => [],
    'class' => null,
    'model' => 'categories',
    'container_atts' => [],
    'container_class' => null,
])
@php
    $categories = $categories ?? get_categories($filters);
@endphp
<fgx:label for="{{ $id }}" :icon="$icon" :required="$required" :label="$label" />

<div {!! attributes($container_atts)->merge([
    'id' => "$id-container",
    'class' => css_classes(['form-control', 'sm', 'max-h-40', 'overflow-auto']),
]) !!}>
    @component('components.select-categories-list', [
        'id' => $id,
        'categories' => $categories,
        'model' => $model,
        'value' => $value,
    ])
    @endcomponent
</div>
<fgx:info :id="$id" :info="$info" />
<fgx:error :id="$id" />
