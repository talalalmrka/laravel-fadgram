<x-settings-page>
    <x-settings-card>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col">
                <fgx:label for="color_primary" :label="__('Primary color')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:select id="color_primary" wire:model.live="color_primary"
                    :options="$colorOptions" />
            </div>
            <div class="col">
                <fgx:label for="color_secondary" :label="__('Secondary color')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:select id="color_secondary" wire:model.live="color_secondary"
                    :options="$colorOptions" />
            </div>

        </div>
    </x-settings-card>
</x-settings-page>
