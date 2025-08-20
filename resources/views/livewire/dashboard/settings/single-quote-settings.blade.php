<x-settings-page>
    <x-settings-card :title="__('Meta')">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="quote_meta_enabled" wire:model.live="quote_meta_enabled"
                    :label="__('Enable meta')" />
            </div>
            <div class="col">
                <fgx:switch id="quote_meta_author" wire:model.live="quote_meta_author" icon="bi-person"
                    :label="__('Author')" />
            </div>
            <div class="col">
                <fgx:switch id="quote_meta_date" wire:model.live="quote_meta_date" icon="bi-clock"
                    :label="__('Date')" />
            </div>
            <div class="col">
                <fgx:switch id="quote_meta_categories" wire:model.live="quote_meta_categories" icon="bi-folder"
                    :label="__('Categories')" />
            </div>
            <div class="col">
                <fgx:switch id="quote_meta_views" wire:model.live="quote_meta_views" icon="bi-eye"
                    :label="__('Views')" />
            </div>
            <div class="col">
                <fgx:switch id="quote_meta_comments" wire:model.live="quote_meta_comments" icon="bi-chat"
                    :label="__('Comments')" />
            </div>

        </div>
    </x-settings-card>

    <x-settings-card :title="__('Books')" icon="bi-book" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col col-span-4">
                <fgx:switch id="quote_books_enabled" wire:model.live="quote_books_enabled"
                    :label="__('Display quote books')" />
            </div>
            <div class="col">
                <fgx:label id="quote_books_label"
                    :label="__('Quote books label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="quote_books_label" wire:model.live="quote_books_label"
                    :info="__('Support (:name => quote name)')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Tags')" class="mt-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="quote_tags_enabled" wire:model.live="quote_tags_enabled"
                    :label="__('Display tags')" />
            </div>
            <div class="col">
                <fgx:label for="quote_tags_label" :label="__('Tags label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="quote_tags_label" wire:model.live="quote_tags_label"
                    :info="__('Supports :name, :permalink')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Share')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="quote_share_enabled" wire:model.live="quote_share_enabled"
                    :label="__('Enable share buttons')" />
            </div>
            <div class="col">
                <fgx:label for="quote_share_label" :label="__('Share label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="quote_share_label" wire:model.live="quote_share_label"
                    :info="__('Supports :name, :permalink')" />
            </div>
        </div>
    </x-settings-card>
    <x-settings-card :title="__('Next previous links')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="quote_next_prev_enabled" wire:model.live="quote_next_prev_enabled"
                    :label="__('Enable next previous links')" />
            </div>
            <div class="col">
                <fgx:label for="quote_next_label" :label="__('Next label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="quote_next_label" wire:model.live="quote_next_label" />
            </div>
            <div class="col">
                <fgx:label for="quote_prev_label" :label="__('Previous label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="quote_prev_label" wire:model.live="quote_prev_label" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Related quotes')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="related_quotes_enabled" wire:model.live="related_quotes_enabled"
                    :label="__('Enable related quotes')" />
            </div>
            <div class="col">
                <fgx:label for="related_quotes_label" :label="__('Related quotes label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="related_quotes_label" wire:model.live="related_quotes_label" />
            </div>
            <div class="col">
                <fgx:label for="related_quotes_count" :label="__('Related quotes count')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="related_quotes_count" wire:model.live="related_quotes_count" />
            </div>
            <div class="col">
                <fgx:label for="related_quotes_query" :label="__('Related quotes query')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:radio id="related_quotes_query" wire:model.live="related_quotes_query"
                    :options="related_query_options()" />
            </div>
        </div>
    </x-settings-card>
</x-settings-page>
