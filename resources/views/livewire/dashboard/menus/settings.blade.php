<form wire:submit="save">
    <fgx:card>
        <fgx:card-header :title="__('Settings')" />
        <fgx:card-body>
            <h5 class="card-title">{{ __('Settings') }}</h5>
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:input id="name" wire:model.live="name" :label="__('Name')" />
                </div>
                <div class="col">
                    <fgx:select id="position" wire:model.live="position" :label="__('Position')"
                        :options="menu_position_options(__('None'))" />
                </div>
                <div class="col">
                    <fgx:input id="class_name" wire:model.live="class_name" :label="__('Css classes')" />
                </div>
            </div>
            <fgx:status class="alert-soft xs mt-2" />
        </fgx:card-body>
        <fgx:card-footer class="flex-space-2 justify-between">
            <button type="submit" class="btn btn-primary sm">
                <i class="icon bi-floppy"></i>
                <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                <fgx:loader wire:loading wire:target="save" />
            </button>

            <button type="button" wire:click="delete" class="btn btn-red sm">
                <i class="icon bi-trash-fill"></i>
                <span wire:loading.remove wire:target="delete">{{ __('Delete') }}</span>
                <fgx:loader wire:loading wire:target="delete" />
            </button>
        </fgx:card-footer>
    </fgx:card>
</form>
