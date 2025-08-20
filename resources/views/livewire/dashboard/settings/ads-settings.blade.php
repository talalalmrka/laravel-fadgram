<x-settings-page>
    <x-settings-card :title="__('Adsense auto')" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="ads_auto_enabled" wire:model.live="ads_auto_enabled" :label="__('Enable')" />
            </div>
            <div class="col">
                <fgx:textarea id="ads_auto_code" wire:model.live="ads_auto_code" :directionButtons="true"
                    :label="__('Code')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Above content')" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="ads_above_content_enabled" wire:model.live="ads_above_content_enabled"
                    :label="__('Enable')" />
            </div>
            <div class="col">
                <fgx:textarea id="ads_above_content_code" wire:model.live="ads_above_content_code"
                    :directionButtons="true" :label="__('Code')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Below content')" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="ads_below_content_enabled" wire:model.live="ads_below_content_enabled"
                    :label="__('Enable')" />
            </div>
            <div class="col">
                <fgx:textarea id="ads_below_content_code" wire:model.live="ads_below_content_code"
                    :directionButtons="true" :label="__('Code')" />
            </div>
        </div>
    </x-settings-card>

</x-settings-page>
