<x-edit-dialog :model="$quoteImage" :title="$title" class="lg">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-100 relative">
        <div class="col md:col-span-2 relative">
            <img src="{{ $reviewUrl }}" alt="" class="max-w-full mx-auto">
        </div>

        <div class="col h-full overflow-y-auto">
            <div class="grid grid-cols-2 gap-4">
                <div class="col col-span-2">
                    <fgx:file id="image" wire:model.live="image" :label="__('Image')" :previews="$previewsImage" />
                </div>
                <div class="col">
                    <x-select-choice model="categories" wire:model.live="categories" class="select-custom"
                        :placeholder="__('Select categories')" :label="__('Categories')" :options="category_choices_options($categories)" :choices="$categories" />
                </div>
                <div class="col">
                    <fgx:select id="font_id" wire:model.live="font_id" :label="__('Font')"
                        :options="font_options()" />
                </div>
                <div class="col">
                    <fgx:input type="number" id="width" wire:model.live="width" :label="__('Width')" />
                </div>
                <div class="col">
                    <fgx:input type="number" id="height" wire:model.live="height" :label="__('Height')" />
                </div>
                <div class="col">
                    <fgx:input type="color" id="color" wire:model.live="color" class="p-0 w-10 h-10"
                        :label="__('Color')" />
                </div>
                <div class="col">
                    <fgx:input type="color" id="border_color" wire:model.live="border_color" class="p-0 w-10 h-10"
                        :label="__('Border color')" />
                </div>
                <div class="col">
                    <fgx:input type="number" id="border_width" wire:model.live="border_width"
                        :label="__('Border width')" />
                </div>
                <div class="col">
                    <fgx:input type="number" id="min_font" wire:model.live="min_font" :label="__('Min font')" />
                </div>
                <div class="col">
                    <fgx:input type="number" id="max_font" wire:model.live="max_font" :label="__('Max font')" />
                </div>
                <div class="col">
                    <fgx:input type="number" step="0.1" id="spacing" wire:model.live="spacing"
                        :label="__('Spacing')" />
                </div>
                <div class="col">
                    <fgx:input type="number" id="max_lines" wire:model.live="max_lines" :label="__('Max lines')" />
                </div>
                <div class="col">
                    <fgx:input type="number" id="padding" wire:model.live="padding" :label="__('Padding')" />
                </div>
                <div class="col">
                    <fgx:select id="align" wire:model.live="align" :label="__('Align')"
                        :options="align_options()" />
                </div>
                <div class="col">
                    <fgx:select id="valign" wire:model.live="valign" :label="__('Vertical align')"
                        :options="valign_options()" />
                </div>
                <div class="col">
                    <fgx:input type="number" min="0" max="100" id="blur" wire:model.live="blur"
                        :label="__('Blur')" />
                </div>
                <div class="col">
                    <fgx:select id="format" wire:model.live="format" :label="__('Format')"
                        :options="image_format_options()" />
                </div>
            </div>
        </div>
    </div>
    <x-slot name="after">
        @teleport('body')
            <x-crop-image-dialog />
        @endteleport
    </x-slot>
</x-edit-dialog>
