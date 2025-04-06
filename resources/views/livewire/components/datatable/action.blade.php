@props([
    'click' => null,
    'href' => null,
    'icon' => null,
    'label' => null,
    'title' => null,
    'color' => null,
    'target' => null,
    'navigate' => true,
    'class' => null,
    'atts' => [],
    'item',
])
@if ($href)
    <a {!! attributes($atts)->merge([
        'href' => call_user_func($href, $item),
        'target' => $target,
        'class' => css_classes([
            $color => $color,
            $class => $class,
            'flex-space-1' => $label && $icon,
        ]),
        'title' => $title ?? __("$click"),
    ]) !!} {{ $navigate ? 'wire:navigate' : '' }}>
        @if ($icon)
            <i class="icon {{ $icon }} w-4 h-4"></i>
        @endif
        @if ($label && $icon)
            <span>{!! $label !!}</span>
        @else
            {!! $label !!}
        @endif
    </a>
@else
    <button {!! attributes($atts)->merge([
        'type' => 'button',
        'wire:click' => "$click($item->id)",
        'class' => css_classes([
            $color => $color,
            $class => $class,
            'flex-space-1' => $label && $icon,
        ]),
        'title' => $title ?? __("$click"),
    ]) !!} {{ $click ? 'wire:click' : '' }}>
        @if ($icon)
            <i class="icon {{ $icon }} w-4 h-4" wire:loading.remove
                wire:target="{{ $click . '(' . $item->id . ')' }}"></i>
        @endif
        @if ($label)
            <span wire:loading.remove wire:target="{{ $click . '(' . $item->id . ')' }}">{!! $label !!}</span>
        @endif
        <fgx:loader wire:loading wire:target="{{ $click . '(' . $item->id . ')' }}" />
    </button>
@endif
