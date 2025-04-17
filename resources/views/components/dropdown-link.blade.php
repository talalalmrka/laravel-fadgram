@props([
    'id' => uniqid('dropdown-link-'),
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
                'class' => css_classes(['dropdown-link', 'active' => $active || request()->is($href), $class => $class]),
                'wire:current' => 'active',
            ],
            $atts,
        ),
    ) }}>
    @icon($icon)
    <span>{!! $label !!}</span>

</a>
