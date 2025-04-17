@props(['position'])

@php
    $menu = menus()->where('position', $position)->first();
@endphp
@if ($menu)
    <div
        {{ $attributes->merge([
            'class' => css_classes(['nav', $menu->class_name => $menu->class_name]),
        ]) }}>
        @if ($menu->items->isNotEmpty())
            @foreach ($menu->items as $item)
                @if ($item->children->isNotEmpty())
                    <div class="dropdown">
                        <button type="button" class="nav-link dropdown-toggle">
                            @icon($item->icon)
                            <span>{{ $item->name }}</span>
                            <i class="icon bi-chevron-down w-3 h-3"></i>
                        </button>
                        <div class="dropdown-menu w-40">
                            @foreach ($item->children as $child)
                                <a href="{{ $child->permalink }}" class="dropdown-link">
                                    @icon($child->icon)
                                    <span>{{ $child->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <x-nav-link icon="{{ $item->icon }}" label="{{ $item->name }}" href="{{ $item->href }}"
                        wire:current="active" class="{{ $item->class_name }}" />
                @endif
            @endforeach
        @endif
    </div>
@endif
