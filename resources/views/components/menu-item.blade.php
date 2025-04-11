@props(['item', 'class' => null, 'atts' => []])
<div
    {{ $attributes->merge(
        array_merge(
            [
                'id' => "menu-item-$item->id",
                'x-sort:item' => $item->id,
                'data-id' => $item->id,
                'class' => css_classes(['sort-container', $class => $class]),
            ],
            $atts,
        ),
    ) }}>
    <div class="card sort-item shadow-none overflow-visible">
        <div class="card-body p-2">
            <div class="flex-space-2">
                <div class="flex-1 flex-space-2 w-full">
                    <span x-sort:handle class="flex items-center handle cursor-move px-2 py-1 rounded hover:bg-gray-100">
                        <i class="icon bi-arrows-move w-4 h-4"></i>
                    </span>
                    <div class="grow flex-space-2">
                        @icon($item->icon)
                        <span class="text-xs">({{ $item->order }})</span>
                        <span class="flex-1">{{ $item->name }}</span>
                    </div>
                    <span class="text-muted text-xs">{{ $item->type }}</span>
                </div>
                <div class="flex-space-1">
                    <button type="button" title="{{ __('Edit') }}"
                        class="flex items-center justify-center w-6 h-6 rounded-full hover:bg-gray-100 text-xs"
                        wire:click="edit({{ $item->id }})">
                        <span wire:loading.remove wire:target="edit({{ $item->id }})" class="flex items-center">
                            <i class="icon bi-pencil-square"></i>
                        </span>
                        <fgx:loader wire:loading wire:target="edit({{ $item->id }})" />
                    </button>
                    <button type="button" title="{{ __('Delete') }}"
                        class="flex items-center justify-center w-6 h-6 rounded-full hover:bg-gray-100 text-xs"
                        wire:click="deleteItem({{ $item->id }})">
                        <span wire:loading.remove wire:target="deleteItem({{ $item->id }})"
                            class="flex items-center">
                            <i class="icon bi-trash-fill"></i>
                        </span>
                        <fgx:loader wire:loading wire:target="deleteItem({{ $item->id }})" />
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div x-sort x-sort.ghost x-sort:group="nested" data-parent="{{ $item->id }}" class="sort nested">
        @if ($item->children->isNotEmpty())
            @foreach ($item->children as $child)
                <x-menu-item :item="$child" />
            @endforeach
        @endif
    </div>
</div>
