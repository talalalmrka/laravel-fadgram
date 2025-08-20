@props([
    'href' => null,
    'label' => null,
    'class' => 'link',
    'target' => null,
    'title' => null,
    'icon' => null,
    'atts' => [],
])
@php
    $label = $label ?? $href;
@endphp
<a {!! $attributes->merge(
    array_merge(
        [
            'href' => $href,
            'title' => $title,
            'target' => $target,
            'class' => css_classes([$class, 'flex-space-2' => $icon]),
        ],
        $atts,
    ),
) !!}>
    @icon($icon)
    @if ($icon)
        <span>{!! isset($slot) && $slot->isNotEmpty() ? $slot : $label !!}</span>
    @else
        {!! isset($slot) && $slot->isNotEmpty() ? $slot : $label !!}
    @endif
</a>
