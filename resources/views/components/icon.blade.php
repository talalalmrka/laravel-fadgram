@props([
    'icon' => null,
    'class' => null,
    'atts' => [],
])

@if ($icon)
    <i
        {{ $attributes->merge(
            array_merge(
                [
                    'class' => css_classes(['icon', $icon => $icon, $class => $class]),
                ],
                $atts,
            ),
        ) }}></i>
@endif
