<form wire:submit="save">
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="col">
                    <fgx:input type="number" id="count" wire:model.live="count" :label="__('Count')" />
                </div>
                <div class="col">
                    <livewire:components.select-user key="user-{{ $user_id ?? 'no' }}"
                        wire:model.live="user_id" :label="__('User')" />
                </div>
                <div class="col">
                    <livewire:components.select-author key="author-{{ $author_id ?? 'no' }}"
                        wire:model.live="author_id" :label="__('Author')" />
                </div>
                <div class="col">
                    <x-rich-select id="categories" wire:model.live="categories" :label="__('Category')"
                        :placeholder="__('Select categories')"
                        :options="category_options(['selected' => $categories])"
                        :selected="$categories" multiple />
                </div>
            </div>
            <div class="mt-4">
                <fgx:label :label="__('Quotes')" />
                @foreach ($quotes as $i => $quote)
                    <div class="card mt-4">
                        <div class="card-header flex items-center justify-between">
                            <span>#{{ $i + 1 }}</span>
                            <button wire:click="delete({{ $i }})" type="button" class="link-red">
                                <i wire:loading.remove wire:target="delete({{ $i }})"
                                    class="icon bi-trash"></i>
                                <i class="icon fg-loader-dots-move" wire:loading
                                    wire:target="delete({{ $i }})"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col">
                                    <fgx:input id="quotes.{{ $i }}.name"
                                        wire:model.live="quotes.{{ $i }}.name" :label="__('Name')" />
                                </div>
                                <div class="col">
                                    <fgx:input id="quotes.{{ $i }}.slug"
                                        wire:model.live="quotes.{{ $i }}.slug" :label="__('Slug')" />
                                </div>
                                <div class="col md:col-span-2">
                                    <fgx:textarea id="quotes.{{ $i }}.content"
                                        wire:model.live="quotes.{{ $i }}.content" :label="__('Content')" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="grid grid-cols-1 gap-4 mt-3">
                <div class="col">
                    <button wire:click="add" type="button" class="btn btn-outline-primary btn-sm">
                        <i class="icon bi-plus-lg"></i>
                        <span wire:loading.remove wire:target="add">{{ __('Add') }}</span>
                        <fgx:loader wire:loading wire:target="add" />
                    </button>
                    <fgx:status id="add" class="alert-soft xs mt-2" />
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">
                        <i class="icon bi-floppy"></i>
                        <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                        <fgx:loader wire:loading wire:target="save" />
                    </button>
                    <fgx:status id="save" class="alert-soft xs mt-2" />
                </div>
            </div>
        </div>
    </div>
</form>
