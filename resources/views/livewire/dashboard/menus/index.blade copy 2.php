<div x-data x-init="() => {
    if (!$wire.selectedMenu && $wire.menus.length > 0) {
        $wire.selectMenu($wire.menus[0].id);
    }
}">
    <!-- Select or create a menu -->
    <div class="flex items-center gap-4 mb-4">
        <div class="w-1/2">
            <label>Select menu</label>
            <select wire:change="selectMenu($event.target.value)" class="form-select w-full">
                <option value="">-- Select Menu --</option>
                @foreach ($menus as $menu)
                    <option value="{{ $menu->id }}" @selected($selectedMenu && $selectedMenu->id == $menu->id)>{{ $menu->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-1/2">
            <label>Create menu</label>
            <div class="flex gap-2">
                <input type="text" wire:model.defer="newMenuName" class="form-input w-full" placeholder="Menu name">
                <button wire:click="createMenu" class="btn btn-success">+ Create</button>
            </div>
        </div>
    </div>

    @if ($selectedMenu)
        <div class="grid grid-cols-3 gap-4">
            <!-- Add menu items -->
            <div>
                <div class="card">
                    <div class="card-header">Add menu items</div>
                    <div class="card-body">
                        <!-- Example: Custom Link -->
                        <details class="mb-2">
                            <summary class="cursor-pointer">Custom link</summary>
                            <div class="mt-2">
                                <input type="text" wire:model.defer="customLink.name" placeholder="Label"
                                    class="form-input mb-2 w-full">
                                <input type="text" wire:model.defer="customLink.url" placeholder="URL"
                                    class="form-input mb-2 w-full">
                                <input type="text" wire:model.defer="customLink.icon" placeholder="Icon (optional)"
                                    class="form-input mb-2 w-full">
                                <select wire:model.defer="customLink.target" class="form-select mb-2 w-full">
                                    <option value="_self">Same tab</option>
                                    <option value="_blank">New tab</option>
                                </select>
                                <button wire:click="addCustomLink" class="btn btn-primary w-full">Add</button>
                            </div>
                        </details>
                    </div>
                </div>
            </div>

            <!-- Menu structure -->
            <div class="col-span-2">
                <div class="card" x-data="menuBuilder({{ json_encode($menuItems) }})">
                    <div class="card-header">Menu structure</div>
                    <div class="card-body">
                        <ul x-ref="sortable" class="space-y-2">
                            <template x-for="(item, index) in items" :key="item.temp_id">
                                <li class="bg-gray-100 rounded p-2" :data-id="item.temp_id">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span x-text="item.icon" class="text-lg"></span>
                                            <span x-text="item.name"></span>
                                        </div>
                                        <span class="text-sm text-gray-500" x-text="item.type"></span>
                                    </div>
                                    <ul class="ml-4 mt-2 space-y-2">
                                        <template x-for="(child, i) in item.children" :key="child.temp_id">
                                            <li class="bg-gray-200 p-2 rounded" :data-id="child.temp_id">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <span x-text="child.icon"></span>
                                                        <span x-text="child.name"></span>
                                                    </div>
                                                    <span class="text-sm text-gray-500" x-text="child.type"></span>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </li>
                            </template>
                        </ul>
                        <button @click="$wire.updateMenuStructure(items)" class="btn btn-success mt-4">Save
                            changes</button>
                    </div>
                </div>

                <!-- Menu settings -->
                <div class="card mt-6">
                    <div class="card-header">Menu settings</div>
                    <div class="card-body space-y-4">
                        <input type="text" wire:model.defer="menuSettings.name" class="form-input w-full"
                            placeholder="Name">
                        <select wire:model.defer="menuSettings.position" class="form-select w-full">
                            <option value="">-- Position --</option>
                            <option value="header">Header</option>
                            <option value="footer">Footer</option>
                        </select>
                        <input type="text" wire:model.defer="menuSettings.class_name" class="form-input w-full"
                            placeholder="Css class">
                        <textarea wire:model.defer="menuSettings.description" class="form-textarea w-full" placeholder="Description"></textarea>
                        <div class="flex gap-2">
                            <button wire:click="saveMenuSettings" class="btn btn-success">Save menu</button>
                            <button wire:click="deleteMenu" class="btn btn-danger">Delete menu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function menuBuilder(initialItems) {
        return {
            items: JSON.parse(JSON.stringify(initialItems || [])),
            // Add more reactive methods if needed
        }
    }
</script>
