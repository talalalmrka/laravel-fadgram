<div>
    <div class="container mx-auto p-4">
        <div class="mb-4">
            <select wire:model="selectedMenu" class="border rounded p-2">
                @foreach ($menus as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                @endforeach
            </select>
            <button wire:click="selectMenu(selectedMenu)" class="bg-blue-500 text-white px-4 py-2 rounded">
                Load Menu
            </button>
        </div>

        @if ($selectedMenu)
            <div id="menu-builder-container" wire:ignore>
                <menu-builder :initial-items="{{ json_encode($menuItems) }}"
                    :available-pages="{{ json_encode($availablePages) }}"
                    :available-posts="{{ json_encode($availablePosts) }}"
                    @update-order="(items) => $wire.$set('menuItems', items)"
                    @add-item="(item) => $wire.addMenuItem(item)" @update-item="(item) => $wire.updateItem(item)"
                    @remove-item="(id) => $wire.removeMenuItem(id)" />
            </div>
        @endif
    </div>
</div>
@script
    @vite(['resources/js/menu-builder.js'])
@endscript
