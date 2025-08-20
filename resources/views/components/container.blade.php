@props([
    'tag' => 'div',
    'contentTag' => 'span',
    'icon' => null,
    'content' => null,
    'class' => null,
    'contentClass' => null,
    'iconClass' => null,
    'atts' => [],
])
{{-- blade-formatter-disable --}}
<{{ $tag }} {!! $attributes->merge(
    array_merge(
        [
            'class' => css_classes([
                'flex-space-2' => $icon && $content,
                $class => $class,
            ]),
        ],
        $atts,
    ),
) !!}>
    @icon($icon, $iconClass)
    @if ($icon)
        {{-- blade-formatter-disable --}}
        <{{ $contentTag }} class="{{ css_classes([$contentClass => $contentClass]) }}">
            {!! isset($slot) && $slot->isNotEmpty() ? $slot : $content !!}
            </{{ $contentTag }}>
        @else
            {!! isset($slot) && $slot->isNotEmpty() ? $slot : $content !!}
    @endif
    {{-- blade-formatter-disable --}}
    </{{ $tag }}>
