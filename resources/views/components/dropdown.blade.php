@props([
    'id' => uniqid('nav-link-dropdown-'),
    'icon' => null,
    'label' => null,
    'toggleIcon' => true,
    'active' => false,
    'class' => null,
    'atts' => [],
    'open' => false,
])
<div x-data="{ open: @js($open) }" x-on:click.away="open = false"
    {{ $attributes->merge(
        array_merge(
            [
                'class' => css_classes(['dropdown', $class => $class]),
            ],
            $atts,
        ),
    ) }}>
    <button x-on:click="open = !open" type="button" class="nav-link dropdown-toggle">
        <span class="dropdown-toggle-label flex-1">
            @icon($icon)
            <span>{{ $label }}</span>
        </span>

        @if ($toggleIcon)
            <i class="icon bi-chevron-down w-3 h-3" :class="{ 'rotate-180': open }"></i>
        @endif
    </button>
    <div class="dropdown-menu w-40">
        {{ $slot }}
    </div>
</div>
