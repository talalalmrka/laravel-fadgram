<x-edit-dialog :model="$category" :title="$title">
    <div class="col md:col-span-3">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:input id="name" wire:model.live="name" :label="__('Name')" />
            </div>
            <div class="col">
                <fgx:input id="slug" wire:model.live="slug" :label="__('Slug')" />
            </div>
            <div class="col">
                <fgx:textarea id="description" wire:model.live="description" :label="__('Description')" />
            </div>
        </div>
    </div>
</x-edit-dialog>
