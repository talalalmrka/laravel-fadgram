<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <livewire:dashboard.menus.create wire:key="create-menu" />
        </div>
        <div class="col">
            <fgx:card>
                <fgx:card-body>
                    <fgx:select id="menu_id" wire:model.live="menu_id" class="sm" :label="__('Select menu')"
                        :options="$menu_options" />
                </fgx:card-body>
            </fgx:card>
        </div>
    </div>
    @if (!empty($menu) && !empty($menu->id))
        <div class="grid grid-cols-1 gap-4 mt-4">
            <div class="col">
                {{ $menu->name }}
                <livewire:dashboard.menus.settings :menu="$menu" wire:key="menu-settings" />
            </div>
        </div>
    @endif
</div>
