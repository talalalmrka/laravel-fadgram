@props([
'sort_label' => __('Default'),
'sort_options' => [],
])
<div class="flex items-center justify-between text-sm mb-2">
    <div class="relative w-40 flex items-center">
        <span class="absolute flex items-center top-0 bottom-0 start-0 px-2">
            @icon('bi-search', 'w-3')
        </span>
        <input type="search" class="form-control xs has-start-icon" placeholder="{{ __('Search') }}"
            wire:model.live="filters.search" />
    </div>
    <div x-data="{ open: false }" class="archive-filter-container">
        <button type="button" x-on:click="open = !open"
            class="form-control xs flex justify-between items-center space-x-1 rtl:space-x-reverse">
            <span class="flex-1 text-left rtl:text-right">{{ $sort_label }}</span>
            @icon('bi-chevron-expand')
        </button>
        <div x-collapse x-show="open" class="archive-filter-dropdown">
            @foreach ($sort_options as $option)
            <button type="button" x-on:click="open = false"
                wire:click="setFilter('sort', '{{ $option['value'] }}')" class="dropdown-link"
                :class="{ 'bg-primary text-bg-primary': @js($option['active']) }">
                <span>{{ data_get($option, 'label') }}</span>
            </button>
            @endforeach
        </div>
    </div>
</div>
