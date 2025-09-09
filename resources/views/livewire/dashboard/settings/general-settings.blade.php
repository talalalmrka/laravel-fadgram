<x-settings-page>
    <x-settings-card :title="__('Site information')" icon="bi-info-circle" body-class="space-y-4">
        <x-settings-row for="name" :label="__('Site name')">
            <fgx:input id="name" wire:model.live="name" />
        </x-settings-row>
        <x-settings-row for="description" :label="__('Description')">
            <fgx:textarea id="description" wire:model.live="description" />
        </x-settings-row>
        <x-settings-row for="url" :label="__('Url')">
            <fgx:input id="url" wire:model.live="url" />
        </x-settings-row>
    </x-settings-card>

    <x-settings-card :title="__('Logo & favicon')" icon="bi-image" class="mt-4" body-class="space-y-4">
        <x-settings-row for="logo" :label="__('Logo')">
            <fgx:file id="logo" wire:model.live="logo" :previews="$this->getPreviews('logo')" />
        </x-settings-row>
        <x-settings-row for="logo_light" :label="__('Logo light')">
            <fgx:file id="logo_light" wire:model.live="logo_light" :previews="$this->getPreviews('logo_light')" />
        </x-settings-row>
        <x-settings-row for="logo_width" :label="__('Logo width (px)')">
            <fgx:input type="number" id="logo_width" wire:model.live="logo_width" />
        </x-settings-row>
        <x-settings-row for="logo_height" :label="__('Logo height (px)')">
            <fgx:input type="number" id="logo_height" wire:model.live="logo_height" />
        </x-settings-row>
        <x-settings-row input-col-class="col-span-4">
            <fgx:switch id="logo_label_enabled" wire:model.live="logo_label_enabled"
                :label="__('Show site name with logo')" />
        </x-settings-row>
        <x-settings-row for="favicon" :label="__('Favicon')">
            <fgx:file id="favicon" wire:model.live="favicon" :previews="$this->getPreviews('favicon')" />
        </x-settings-row>
    </x-settings-card>

    <x-settings-card :title="__('Language & Region')" icon="bi-translate" class="mt-4" body-class="space-y-4">
        <x-settings-row for="locale" :label="__('Language')">
            <fgx:select id="locale" wire:model.live="locale" :options="locale_options()" />
        </x-settings-row>
        <x-settings-row for="timezone" :label="__('Timezone')">
            <fgx:select id="timezone" wire:model.live="timezone" :options="timezone_options()" />
        </x-settings-row>
        <x-settings-row for="date_format" :label="__('Date format')">
            <fgx:input id="date_format" wire:model.live="date_format" />
        </x-settings-row>
    </x-settings-card>

    <x-settings-card :title="__('Site status')" icon="bi-house-gear-fill" class="mt-4" body-class="space-y-4">
        <x-settings-row input-col-class="col-span-4">
            <fgx:switch id="maintenance" wire:model.live="maintenance"
                :label="__('Maintenance mode')" />
        </x-settings-row>
        <x-settings-row input-col-class="col-span-4">
            <fgx:switch id="closed" wire:model.live="closed"
                :label="__('Close website')" />
        </x-settings-row>
    </x-settings-card>

</x-settings-page>
