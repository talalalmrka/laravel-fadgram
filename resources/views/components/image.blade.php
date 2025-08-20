@props([
    'src' => null,
    'alt' => null,
    'class' => null,
    'atts' => [],
])
<img {!! $attributes->merge(
    array_merge(
        [
            'src' => $src,
            'alt' => $alt,
            'class' => css_classes([$class => $class]),
        ],
        $atts,
    ),
) !!}>
