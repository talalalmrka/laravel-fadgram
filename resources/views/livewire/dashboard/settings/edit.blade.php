<x-edit-dialog :model="$setting" :title="$title">
    <div class="grid grid-cols-1 gap-4">
        <div class="col">
            <fgx:input id="type" wire:model.live="type" :label="__('Type')" readonly disabled />
        </div>
        <div class="col">
            <fgx:input id="key" wire:model.live="key" :label="__('Key')" />
        </div>
        @if ($type === 'boolean')
            <div class="col">
                <fgx:switch id="value" wire:model.live="value" :label="__('Value')" />
                <fgx:input id="value" wire:model.live="value" :label="__('Value')" />
            </div>
        @else
            <div class="col">
                <fgx:textarea id="value" wire:model.live="value" :label="__('Value')" />
            </div>
        @endif
    </div>
</x-edit-dialog>
