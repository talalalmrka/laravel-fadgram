@props([
    'label' => null,
    'icon' => null,
    'open' => false,
])
<div x-cloak x-data="{ open: @js($open) }" class="block w-full">
    <a href="#!" x-on:click.prevent="open = !open"
        class="flex-space-2 text-sm w-full px-3 py-2 justify-between">
        @icon($icon)
        <span class="grow text-start">{{ $label }}</span>
        <i x-cloak class="icon bi-chevron-down" :class="{ 'rotate-180': open }"></i>
    </a>
    <nav x-collapse x-show="open" class="nav vertical ms-3 px-2 py-3 border-s border-s-white/50">
        {{ $slot }}
    </nav>
</div>
