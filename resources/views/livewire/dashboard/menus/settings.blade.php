<div wire:cloak>
    @if (!empty($menu) && !empty($menu->id))
        <form wire:submit="save">
            <fgx:collapse-card id="menuSettings{{ $menu->id }}" icon="bi-gear-wide-connected"
                :title="__('Settings (:name)', ['name' => $name])">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:input id="name" wire:model.live="name" class="sm" :label="__('Name')" />
                    </div>
                    <div class="col">

                        <fgx:radio id="position" wire:model.live="position" :label="__('Position')"
                            :options="menu_position_options(__('None'))" />
                    </div>
                    <div class="col">
                        <fgx:input id="class_name" wire:model.live="class_name" class="sm"
                            :label="__('Css classes')" />
                    </div>
                    <div class="col">
                        <button type="button" wire:click="delete"
                            class="flex-space-1 text-red hover:underline text-sm">
                            <i class="icon bi-trash-fill"></i>
                            <span wire:loading.remove wire:target="delete">{{ __('Delete') }}</span>
                            <fgx:loader wire:loading wire:target="delete" />
                        </button>
                    </div>
                </div>
                <x-slot name="footer">
                    <div class="flex-space-2 justify-between">
                        <button type="submit" class="btn btn-primary sm">
                            <i class="icon bi-floppy"></i>
                            <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                            <fgx:loader wire:loading wire:target="save" />
                        </button>
                        <div class="grow">
                            <fgx:status class="alert-outline text-sm bg-transparent border-0" />
                        </div>
                    </div>
                </x-slot>
            </fgx:collapse-card>
        </form>
    @else
        <fgx:alert type="info" soft :content="__('Nothing selected')" />
    @endif
</div>
