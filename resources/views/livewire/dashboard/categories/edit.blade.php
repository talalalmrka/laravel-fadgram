<x-edit-dialog :model="$category" :title="$title">
    <div class="grid grid-cols-4 gap-4">
        <div class="col md:col-span-3">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:input id="name" wire:model.live="name" :label="__('Name')" />
                </div>
                <div class="col">
                    <fgx:input id="slug" wire:model.live="slug" :label="__('Slug')" />
                </div>
                <div class="col">
                    <fgx:select id="parent_id" wire:model.live="parent_id" :label="__('Parent')"
                        :options="category_options(__('None'))" />
                </div>
                <div class="col">
                    <fgx:textarea id="description" wire:model.live="description" :label="__('Description')" />
                </div>
            </div>
        </div>
        <div class="col">
            <fgx:file id="thumbnail" wire:model.live="thumbnail" :label="__('Thumbnail')"
                :previews="$previewsThumbnail" />
        </div>
    </div>

</x-edit-dialog>
