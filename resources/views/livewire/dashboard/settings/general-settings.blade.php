<x-settings-page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <x-settings-card :title="__('Site information')" icon="bi-info-circle">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:input id="name" wire:model.live="name" :label="__('Name')" />
                    </div>
                    <div class="col">
                        <fgx:textarea id="description" wire:model.live="description" :label="__('Description')" />
                    </div>
                    <div class="col">
                        <fgx:input type="url" id="url" wire:model.live="url" :label="__('Url')" />
                    </div>
                </div>
            </x-settings-card>
        </div>
        <div class="col">
            <x-settings-card :title="__('Logo & favicon')" icon="bi-image">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col">
                        <fgx:file id="logo" wire:model.live="logo" :label="__('Logo')"
                            :previews="$this->getPreviews('logo')" />
                    </div>
                    <div class="col">
                        <fgx:file id="logo_light" wire:model.live="logo_light" :label="__('Logo light')"
                            :previews="$this->getPreviews('logo_light')" />
                    </div>
                    <div class="col">
                        <fgx:input type="number" id="logo_width" wire:model.live="logo_width"
                            :label="__('Logo width (px)')" />
                    </div>
                    <div class="col">
                        <fgx:input type="number" id="logo_height" wire:model.live="logo_height"
                            :label="__('Logo height (px)')" />
                    </div>
                    <div class="col col-span-2">
                        <fgx:switch id="logo_label_enabled" wire:model.live="logo_label_enabled"
                            :label="__('Show site name with logo')" />
                    </div>
                    <div class="col">
                        <fgx:file id="favicon" wire:model.live="favicon" :label="__('Favicon')"
                            :previews="$this->getPreviews('favicon')" />
                    </div>
                </div>
            </x-settings-card>
        </div>
        <div class="col">
            <x-settings-card :title="__('Language & Region')" icon="bi-translate">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:select id="locale" wire:model.live="locale" :label="__('Language')"
                            :options="locale_options()" />
                    </div>
                    <div class="col">
                        <fgx:select id="timezone" wire:model.live="timezone" :label="__('Timezone')" :options="timezone_options()"/>
                    </div>
                    <div class="col">
                        <fgx:input id="date_format" wire:model.live="date_format" :label="__('Date format')"/>
                    </div>
                </div>
            </x-settings-card>
        </div>
        <div class="col">
            <x-settings-card :title="__('Site status')" icon="bi-house-gear-fill">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:switch id="maintenance" wire:model.live="maintenance" :label="__('Maintenance mode')"/>
                    </div>
                    <div class="col">
                        <fgx:switch id="closed" wire:model.live="closed" :label="__('Close website')"/>
                    </div>
                </div>
            </x-settings-card>
        </div>
    </div>
</x-settings-page>