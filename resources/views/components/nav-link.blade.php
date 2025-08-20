@props([
    'id' => uniqid('nav-link-'),
    'icon' => null,
    'label' => '',
    'href' => '#',
    'navigate' => true,
    'target' => null,
    'active' => false,
    'class' => null,
    'atts' => [],
])
@php
    if ($navigate) {
        $atts['wire:navigate'] = '';
    }
    if ($target) {
        $atts['target'] = $target;
    }
@endphp
<a
    {{ $attributes->merge(
        array_merge(
            [
                'id' => $id,
                'href' => $href,
                'class' => css_classes(['nav-link', 'active' => $active || request()->is($href), $class => $class]),
            ],
            $atts,
        ),
    ) }}>
    @icon($icon)
    <span>{!! $label !!}</span>
    {{ $slot ?? '' }}
</a>
