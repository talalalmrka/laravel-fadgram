@props([
    'sort_options' => [],
    'category_options' => null,
])
<div class="lg:flex items-center justify-between mb-3">
    <fgx:input id="filters.search" wire:model.live="filters.search" startIcon="bi-search" class="sm"
        container_class="lg:w-60"
        :placeholder="__('Search')" />
    <div class="flex-space-3 justify-end mt-3 lg:mt-0">
        @if ($category_options)
            <div class="lg:w-60">
                <fgx:select id="filters.category" wire:model.live="filters.category" startIcon="bi-funnel-fill"
                    :options="$category_options" class="sm" />
            </div>
        @endif
        <div class="lg:w-60">
            <fgx:select id="filters.sort" wire:model.live="filters.sort" startIcon="bi-sort-up"
                :options="$sort_options" class="sm" />
        </div>
    </div>
</div>
