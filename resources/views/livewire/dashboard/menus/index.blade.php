<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <livewire:dashboard.menus.create wire:key="create-menu" />
        </div>
        <div class="col">
            <fgx:card>
                <fgx:card-body>
                    <fgx:select id="menu_id" wire:model.live="menu_id" class="sm" :label="__('Select menu')"
                        :options="menu_options(__('None'))" wire:key="menu-select-{{ $this->menu?->id ?? uniqid() }}" />
                </fgx:card-body>
            </fgx:card>
        </div>
    </div>
    <div class="mt-4">
        <button wire:click="resetDefaults" type="button" class="btn btn-red btn-xs pill">
            <i class="icon bi-arrow-counterclockwise"></i>
            <span wire:loading.remove wire:target="resetDefaults">{{ __('Reset defaults') }}</span>
            <fgx:loader wire:loading wire:target="resetDefaults" />
        </button>
        <fgx:status id="reset_status" class="alert-soft xs mt-2" />
    </div>
    @if ($this->menu)
        <div class="grid grid-cols-1 gap-4 mt-4">
            <div class="col">
                <livewire:dashboard.menus.settings :menu="$this->menu"
                    wire:key="menu-settings-{{ $this->menu?->id ?? uniqid() }}" />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="col">
                <livewire:dashboard.menus.add :menu="$this->menu"
                    wire:key="menu-add-{{ $this->menu?->id ?? uniqid() }}" />
            </div>
            <div class="col md:col-span-2">
                <livewire:dashboard.menus.structure :menu="$this->menu"
                    wire:key="menu-structure-{{ $this->menu?->id ?? uniqid() }}" />
            </div>
        </div>
    @else
        <fgx:alert soft class="mt-3" :content="__('No menu selected!')" />
    @endif


</div>
@script
    <script>
        $js('reseted', () => {
            $wire.$refresh();
        });
    </script>
@endscript
