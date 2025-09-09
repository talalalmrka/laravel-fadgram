@props([
    'id' => null,
    'label' => null,
    'icon' => null,
    'for' => null,
    'class' => null,
    'atts' => [],
    'labelColClass' => null,
    'labelColAtts' => [],
    'labelClass' => null,
    'labelAtts' => [],
    'inputColClass' => null,
    'inputColAtts' => [],
])
<div
    {!! $attributes->merge([
        'id' => $id,
        'class' => css_classes(['grid grid-cols-1 lg:grid-cols-4 gap-4', $class => $class]),
    ]) !!}>
    @if ($label)
        <div {{ attributes($labelColAtts)->merge([
            'class' => css_classes(['col', $labelColClass => $labelColClass]),
        ]) }}
            class="col">
            <fgx:label :for="$for" :label="$label" :icon="$icon" :class="$labelClass" />
        </div>
    @endif

    <div
        {{ attributes($inputColAtts)->merge([
            'class' => css_classes(['col lg:col-span-3', $inputColClass => $inputColClass]),
        ]) }}>
        {{ $slot }}
    </div>
</div>
