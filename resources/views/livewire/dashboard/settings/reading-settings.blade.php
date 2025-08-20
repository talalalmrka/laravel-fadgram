<x-settings-page>
    <x-settings-card>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col">
                <fgx:label for="front_type" :label="__('Your homepage displays')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:radio id="front_type" wire:model.live="front_type" :options="front_type_options()" />
            </div>
            <div class="col">
                <fgx:label for="front_page" :label="__('Homepage')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:select id="front_page" wire:model.live="front_page" :disabled="$front_type !== 'page'"
                    :options="page_options()" />
            </div>
            <div class="col">
                <fgx:label for="posts_page" :label="__('Posts page')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:select id="posts_page" wire:model.live="posts_page" :disabled="$front_type !== 'page'"
                    :options="page_options()" />
            </div>
            <div class="col">
                <fgx:label for="posts_per_page" :label="__('Posts per page')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" min="5" max="50" id="posts_per_page"
                    wire:model.live="posts_per_page" />
            </div>
            <div class="col">
                <fgx:label for="disable_search_engines"
                    :label="__('Discourage search engines from indexing this site')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:switch wire:model.live="disable_search_engines" />
            </div>
        </div>
    </x-settings-card>
</x-settings-page>
