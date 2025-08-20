<x-settings-page>
    <x-settings-card :title="__('Share')">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="book_share_enabled" wire:model.live="book_share_enabled"
                    :label="__('Enable share buttons')" />
            </div>
            <div class="col">
                <fgx:label for="book_share_label" :label="__('Share label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="book_share_label" wire:model.live="book_share_label"
                    :info="__('Supports :name, :permalink, :link')" />
            </div>
        </div>
    </x-settings-card>
    <x-settings-card :title="__('Quotes section')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="book_display_quotes" wire:model.live="book_display_quotes"
                    :label="__('Display quotes')" />
            </div>
            <div class="col">
                <fgx:label for="book_quotes_section_title" :label="__('Quotes section title')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="book_quotes_section_title" wire:model.live="book_quotes_section_title"
                    :info="__('supported (:name => book name), (:permalink => book permalink)')" />
            </div>
            <div class="col lg:col-span-4">
                <fgx:switch id="book_add_quote" wire:model.live="book_add_quote"
                    :label="__('Users can add new quotes')" />
            </div>
            <div class="col lg:col-span-4">
                <fgx:switch id="book_quote_approve_required" wire:model.live="book_quote_approve_required"
                    :label="__('Quote must be manually approved')" />
            </div>
            <div class="col lg:col-span-4">
                <fgx:switch id="book_quote_approve_previous" wire:model.live="book_quote_approve_previous"
                    :label="__('Quote author must have a previously approved quote')" />
            </div>
            <div class="col">
                <fgx:label for="book_quotes_per_page" :label="__('Quotes per page')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="book_quotes_per_page" wire:model.live="book_quotes_per_page"
                    class="inline-block w-auto" />
            </div>
            <div class="col">
                <fgx:label for="book_quotes_sort" :label="__('Sort by')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:select id="book_quotes_sort" wire:model.live="book_quotes_sort" :options="sort_options()"
                    class="inline-block w-auto" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Next previous links')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="book_next_prev_enabled" wire:model.live="book_next_prev_enabled"
                    :label="__('Enable next previous links')" />
            </div>
            <div class="col">
                <fgx:label for="book_next_label" :label="__('Next label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="book_next_label" wire:model.live="book_next_label" />
            </div>
            <div class="col">
                <fgx:label for="book_prev_label" :label="__('Previous label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="book_prev_label" wire:model.live="book_prev_label" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Related books')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="related_books_enabled" wire:model.live="related_books_enabled"
                    :label="__('Enable related books')" />
            </div>
            <div class="col">
                <fgx:label for="related_books_label" :label="__('Related books label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="related_books_label" wire:model.live="related_books_label" />
            </div>
            <div class="col">
                <fgx:label for="related_books_count" :label="__('Related books count')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="related_books_count" wire:model.live="related_books_count" />
            </div>
            <div class="col">
                <fgx:label for="related_books_query" :label="__('Related books query')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:radio id="related_books_query" wire:model.live="related_books_query"
                    :options="related_query_options()" />
            </div>
        </div>
    </x-settings-card>
</x-settings-page>
