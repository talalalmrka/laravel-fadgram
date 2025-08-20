<x-settings-page>
    <x-settings-card>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col">
                <fgx:label for="permalink_structure" :label="__('Permalink structure')" />
            </div>
            <div class="col lg:col-span-3">
                <div>{{ url('/') }}</div>
                <fgx:input id="permalink_structure" wire:model.live="permalink_structure" />
            </div>
            <div class="col">
                <fgx:label for="category_base" :label="__('Category base')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="category_base" wire:model.live="category_base" />
            </div>
            <div class="col">
                <fgx:label for="tag_base" :label="__('Tag base')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="tag_base" wire:model.live="tag_base" />
            </div>

        </div>
    </x-settings-card>
</x-settings-page>
