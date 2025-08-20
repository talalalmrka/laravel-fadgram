@props([
    'icon' => null,
    'icon_position' => 'start',
    'label' => null,
    'type' => 'button',
    'href' => null,
    'target' => null,
    'color' => 'primary',
    'outline' => false,
    'gradient' => false,
    'pill' => false,
    'size' => null,
    'class' => null,
    'atts' => [],
])
@php

    $colors = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'light' => 'btn-light',
        'dark' => 'btn-dark',
        'white' => 'btn-white',
        'black' => 'btn-black',
        'red' => 'btn-red',
        'blue' => 'btn-blue',
        'green' => 'btn-green',
        'yellow' => 'btn-yellow',
        'pink' => 'btn-pink',
        'purple' => 'btn-purple',
        'indigo' => 'btn-indigo',
        'gray' => 'btn-gray',
        'orange' => 'btn-orange',
        'teal' => 'btn-teal',
        'cyan' => 'btn-cyan',
        'lime' => 'btn-lime',
        'amber' => 'btn-amber',
        'emerald' => 'btn-emerald',
        'fuchsia' => 'btn-fuchsia',
        'rose' => 'btn-rose',
        'sky' => 'btn-sky',
        'slate' => 'btn-slate',
        'zinc' => 'btn-zinc',
        'neutral' => 'btn-neutral',
        'stone' => 'btn-stone',
    ];
    $outlineColors = [
        'primary' => 'btn-outline-primary',
        'secondary' => 'btn-outline-secondary',
        'light' => 'btn-outline-light',
        'dark' => 'btn-outline-dark',
        'white' => 'btn-outline-white',
        'black' => 'btn-outline-black',
        'red' => 'btn-outline-red',
        'blue' => 'btn-outline-blue',
        'green' => 'btn-outline-green',
        'yellow' => 'btn-outline-yellow',
        'pink' => 'btn-outline-pink',
        'purple' => 'btn-outline-purple',
        'indigo' => 'btn-outline-indigo',
        'gray' => 'btn-outline-gray',
        'orange' => 'btn-outline-orange',
        'teal' => 'btn-outline-teal',
        'cyan' => 'btn-outline-cyan',
        'lime' => 'btn-outline-lime',
        'amber' => 'btn-outline-amber',
        'emerald' => 'btn-outline-emerald',
        'fuchsia' => 'btn-outline-fuchsia',
        'rose' => 'btn-outline-rose',
        'sky' => 'btn-outline-sky',
        'slate' => 'btn-outline-slate',
        'zinc' => 'btn-outline-zinc',
        'neutral' => 'btn-outline-neutral',
        'stone' => 'btn-outline-stone',
    ];
    $gradientColors = [
        'primary' => 'btn-gradient-primary',
        'secondary' => 'btn-gradient-secondary',
        'red' => 'btn-gradient-red',
        'blue' => 'btn-gradient-blue',
        'green' => 'btn-gradient-green',
        'yellow' => 'btn-gradient-yellow',
        'pink' => 'btn-gradient-pink',
        'purple' => 'btn-gradient-purple',
        'indigo' => 'btn-gradient-indigo',
        'gray' => 'btn-gradient-gray',
        'orange' => 'btn-gradient-orange',
        'teal' => 'btn-gradient-teal',
        'cyan' => 'btn-gradient-cyan',
        'lime' => 'btn-gradient-lime',
        'amber' => 'btn-gradient-amber',
        'emerald' => 'btn-gradient-emerald',
        'fuchsia' => 'btn-gradient-fuchsia',
        'rose' => 'btn-gradient-rose',
        'sky' => 'btn-gradient-sky',
        'slate' => 'btn-gradient-slate',
        'zinc' => 'btn-gradient-zinc',
        'neutral' => 'btn-gradient-neutral',
        'stone' => 'btn-gradient-stone',
    ];
    $sizes = [
        'xxs' => 'btn-xxs',
        'xs' => 'btn-xs',
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        'xl' => 'btn-xl',
        'xxl' => 'btn-xxl',
    ];
    $colorClass = match (true) {
        // $gradient => data_get($gradientColors, $color),
        $outline => data_get($outlineColors, $color),
        default => data_get($colors, $color),
    };

    $sizeClass = $size ? data_get($sizes, $size) : null;

@endphp
@if ($href)
    <a
        {{ $attributes->merge(
            array_merge(
                [
                    'href' => $href,
                    'target' => $target,
                    'class' => css_classes([
                        'btn',
                        $colorClass => $colorClass,
                        $sizeClass => $sizeClass,
                        'gradient' => $gradient,
                        'pill' => $pill,
                        $class => $class,
                        'flex-space-2' => $icon && $label,
                    ]),
                ],
                $atts,
            ),
        ) }}>
        @if ($icon && $icon_position === 'start')
            @icon($icon)
        @endif

        @if ($label)
            @if ($icon)
                <span>{{ $label }}</span>
            @else
                {{ $label }}
            @endif
        @endif
        @if ($icon && $icon_position === 'end')
            @icon($icon)
        @endif

    </a>
@else
    <button
        {{ $attributes->merge(
            array_merge(
                [
                    'type' => $type,
                    'class' => css_classes([
                        'btn',
                        $colorClass => $colorClass,
                        $sizeClass => $sizeClass,
                        'gradient' => $gradient,
                        'pill' => $pill,
                        $class => $class,
                        'flex-space-2' => $icon && $label,
                    ]),
                ],
                $atts,
            ),
        ) }}>
        @if ($icon && $icon_position === 'start')
            @icon($icon)
        @endif

        @if ($label)
            @if ($icon)
                <span>{{ $label }}</span>
            @else
                {{ $label }}
            @endif
        @endif
        @if ($icon && $icon_position === 'end')
            @icon($icon)
        @endif

    </button>
@endif
