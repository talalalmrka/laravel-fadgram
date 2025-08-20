@props(['color', 'class' => null, 'atts' => []])

<div
    {{ $attributes->merge(
        array_merge(
            [
                'class' => css_classes(['w-5 h-5 inline-block rounded-full border', $class => $class]),
                'style' => "background-color: $color;",
            ],
            $atts,
        ),
    ) }}>
</div>
