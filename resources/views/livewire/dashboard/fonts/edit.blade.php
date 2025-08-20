<x-edit-dialog :model="$font" :title="$title">
    <div class="grid grid-cols-1 gap-4">
        <div class="col">
            <fgx:input id="name" wire:model.live="name" :label="__('Font family')" />
        </div>
        <div class="col">
            <fgx:switch id="enabled" wire:model.live="enabled" :label="__('Enabled')" :checked="boolval($enabled)"/>
        </div>
        <div class="col">
            <fgx:select wire:model.live="style" id="style" :label="__('Font style')"
                :options="font_style_options()" />
        </div>
        <div class="col">
            <fgx:select wire:model.live="weight" id="weight" :label="__('Font Weight')"
                :options="font_weight_options()" />
        </div>
        <div class="col">
            <fgx:select wire:model.live="display" id="display" :label="__('Font Display')"
                :options="font_display_options()" />
        </div>
        <div class="col">
            <fgx:file wire:model.live="file" id="file" :label="__('Font file')" accept=".ttf,.woff,.woff2,.otf"
                :previews="$font->getPreviews()" />
        </div>
    </div>
</x-edit-dialog>
