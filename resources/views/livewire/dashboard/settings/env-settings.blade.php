<x-settings-page :showReset="false">
    <x-settings-card :title="__('Environment variables')">
        <fgx:textarea id="env" wire:model.live="env" rows="20" :directionButtons="true" />
    </x-settings-card>
</x-settings-page>
