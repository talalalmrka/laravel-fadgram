<x-edit-dialog :model="$media" :title="$title">
    <div class="grid grid-cols-1 gap-4">
        <div class="col">
            <fgx:input id="name" wire:model.live="name" :label="__('Name')" />
        </div>
        <div class="col">
            <fgx:radio id="collection_name" wire:model.live="collection_name" :label="__('Collection name')"
                :options="$collection_options" />
        </div>
        <div class="col">
            <fgx:input id="file_name" wire:model.live="file_name" :label="__('File name')" />
        </div>
    </div>
</x-edit-dialog>
