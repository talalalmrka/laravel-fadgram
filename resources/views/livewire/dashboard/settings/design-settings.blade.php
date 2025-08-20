<x-settings-page>
    <x-settings-card :title="__('Header settings')" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="header_code_enabled" wire:model.live="header_code_enabled"
                    :label="__('Enable header code')" />
            </div>
            <div class="col">
                <fgx:textarea id="header_code" wire:model.live="header_code" :directionButtons="true"
                    :label="__('Code')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Footer settings')" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="backtop_enabled" wire:model.live="backtop_enabled"
                    :label="__('Enable back top button')" />
            </div>
            <div class="col">
                <fgx:textarea id="footer_copyrights" wire:model.live="footer_copyrights" :directionButtons="true"
                    :label="__('Footer copyrights')"
                    :info="__('Supported shortcodes (:name = Site name, :link = Site link, :description Site description, :year = Current year).')" />
            </div>
            <div class="col">
                <fgx:switch id="footer_code_enabled" wire:model.live="footer_code_enabled"
                    :label="__('Enable footer code')" />
            </div>
            <div class="col">
                <fgx:textarea id="footer_code" wire:model.live="footer_code" :directionButtons="true"
                    :label="__('Footer code')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Custom css code')" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="custom_css_enabled" wire:model.live="custom_css_enabled" :label="__('Enable')" />
            </div>
            <div class="col">
                <fgx:textarea id="custom_css" wire:model.live="custom_css" :directionButtons="true"
                    :label="__('Code')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Custom javascript code')" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="custom_js_enabled" wire:model.live="custom_js_enabled" :label="__('Enable')" />
            </div>
            <div class="col">
                <fgx:textarea id="custom_js" wire:model.live="custom_js" :directionButtons="true"
                    :label="__('Code')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Debug')" icon="bi-bug-fill" class="mb-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="eruda_enabled" wire:model.live="eruda_enabled" :label="__('Enable eruda js')" />
            </div>
        </div>
    </x-settings-card>

</x-settings-page>
