<div x-data="{ open: false }" class="relative" x-on:click.away="open = false">
    <fgx:label for="{{ $id }}" :icon="$icon" :required="$required" :label="$label" />
    <div type="button" class="form-control flex-space-2 cursor-pointer items-center">
        <span x-on:click="open = !open" class="flex-1">{{ $selectedLabel }}</span>
        <button wire:show="value" wire:click="$set('value', null)" type="button">
            @icon('bi-x-lg')
        </button>
        @icon('bi-chevron-expand')
    </div>
    <div x-collapse x-show="open"
        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden">
        <div class="p-2 border-b">
            <div class="form-control-container">
                <span class="start-icon">
                    <i class="icon bi-search"></i>
                </span>
                <input
                    type="search"
                    wire:model.live="search"
                    placeholder="{{ __('Search') }}"
                    class="form-control sm has-start-icon">
            </div>
        </div>
        <div class="max-h-48 overflow-y-auto">
            @foreach ($options as $option)
                <button
                    type="button"
                    wire:click="$set('value', {{ $option->value }})"
                    x-on:click="open = false"
                    class="w-full px-4 py-2 text-left text-sm hover:bg-blue-50 focus:bg-blue-50 focus:outline-none transition-colors duration-150 {{ $option->selected ? 'bg-primary-100 text-primary-900' : 'text-gray-500' }}">
                    {{ $option->label }}
                </button>
            @endforeach
        </div>
    </div>
    <fgx:info :id="$id" :info="$info" />
    <fgx:error :id="$id" />
</div>
