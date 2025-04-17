@props(['menu', 'atts' => []])
<div
    {{ $attributes->merge(
        array_merge(
            [
                'class' => css_classes(['nav', $menu->class_name => $menu->class_name]),
            ],
            $atts,
        ),
    ) }}>
    @if ($menu->items->isNotEmpty())
        @foreach ($menu->items as $item)
            {!! $item->render() !!}
        @endforeach
    @endif
</div>
