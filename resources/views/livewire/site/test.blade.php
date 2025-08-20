<div class="container">
    @dump(author_options(['selected' => $author_id]))
    @dump($author_id)
    <div class="grid grid-cols-1 gap-4 mt-4">
        <div class="col">

            <x-rich-select id="author_id" wire:model.live="author_id" :label="__('Author')" :placeholder="__('Select author')"
                :options="author_options(['selected' => $author_id])"
                ajaxUrl="{{ route('api.authors') }}" :selected="$author_id" />
        </div>
        <div class="col">

        </div>
    </div>
    <div class="min-h-[50vh]">

    </div>
</div>
