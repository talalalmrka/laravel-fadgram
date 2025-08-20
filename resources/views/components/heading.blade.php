@props([
    'tag' => 'h2',
    'title' => '',
    'class' => 'text-center text-lg md:text-xl lg:text-2xl mt-6',
    'stripClass' => 'w-20 border-2 border-primary rounded mx-auto mb-6',
    'atts' => [],
])
@php
    $content = isset($slot) && $slot->isNotEmpty() ? $slot : $title;
@endphp
<{{ $tag }}
    {{ $attributes->merge(
        array_merge(
            [
                'class' => css_classes([
                    $class => $class,
                ]),
            ],
            $atts,
        ),
    ) }}>
    {!! $content !!}
    </{{ $tag }}>
    <hr class="{{ $stripClass }}" />
