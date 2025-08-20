@props([
    'title' => null,
    'icon' => null,
    'class' => null,
    'atts' => [],
    'titleClass' => '',
    'tag' => 2,
    'color' => 'primary',
])
@php
    $borderColors = [
        'primary' => 'border-primary',
        'secondary' => 'border-secondary',
        'red' => 'border-red',
        'blue' => 'border-blue',
        'green' => 'border-green',
        'yellow' => 'border-yellow',
        'pink' => 'border-pink',
        'purple' => 'border-purple',
        'indigo' => 'border-indigo',
        'gray' => 'border-gray',
        'orange' => 'border-orange',
        'teal' => 'border-teal',
        'cyan' => 'border-cyan',
        'lime' => 'border-lime',
        'amber' => 'border-amber',
        'emerald' => 'border-emerald',
        'fuchsia' => 'border-fuchsia',
        'rose' => 'border-rose',
        'sky' => 'border-sky',
        'slate' => 'border-slate',
        'zinc' => 'border-zinc',
        'neutral' => 'border-neutral',
        'ayoue' => 'border-stone',
    ];
    $borderClass = data_get($borderColors, $color);
@endphp
@if ($title || $icon)
    <div
        {{ $attributes->merge(
            array_merge(
                [
                    'class' => css_classes(['mb-3', $class => $class]),
                ],
                $atts,
            ),
        ) }}>
        <div class="flex-space-2 mb-2">
            <h{{ $tag }}
                class="{{ css_classes(['text-base md:text-lg lg:text-xl mb-0', 'flex-1 flex-space-2' => $title && $icon, $titleClass => $titleClass]) }}">
                @if ($icon)
                    @icon("$icon me-2")
                @endif

                {!! $title !!}
                </h{{ $tag }}>
                @if (isset($actions))
                    {!! $actions !!}
                @endif
        </div>

        <div class="flex items-center">
            <div class="{{ css_classes(['w-20 border-b-2', $borderClass => $borderClass]) }}"></div>
            <div class="grow border-b"></div>
        </div>
    </div>
@endif
