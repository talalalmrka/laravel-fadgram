<div>
    <x-slot name="actions">
        @if (route_has('dashboard.quotes'))
            <a wire:navigate href="{{ route('dashboard.quotes') }}" class="btn btn-blue btn-xs pill w-20">
                <i class="icon bi-list-ul"></i>
                <span>{{ __('All') }}</span>
            </a>
        @endif

        @if (method_exists($this, 'saved') && $this->saved() && route_has('dashboard.quotes.create'))
            <a wire:navigate href="{{ route('dashboard.quotes.create') }}"
                class="btn btn-emerald btn-xs pill w-20">
                <i class="icon fg-plus"></i>
                <span>{{ __('Create') }}</span>
            </a>
        @endif
    </x-slot>
    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="col md:col-span-3">
                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="col">
                                <fgx:input wire:model.live="name" id="name" :label="__('Name')" autofocus />
                                @if ($this->saved())
                                    <a href="{{ $quote->permalink }}" target="_blank"
                                        class="link text-sm flex-space-2 mt-2">
                                        <i class="icon bi-box-arrow-up-right"></i>
                                        <span>{{ $quote->permalink }}</span>
                                    </a>
                                @endif
                            </div>
                            <div class="col">
                                <fgx:input wire:model.live="slug" id="slug" :label="__('Slug')" autofocus />

                            </div>
                            <div class="col">
                                <fgx:textarea wire:model.live="content" id="content"
                                    :label="__('Quote')" />
                            </div>
                            <div class="col">
                                @include('livewire.dashboard.quotes.quote-images')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Column 1 -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="col">
                                <fgx:label for="quote_image_id" :label="__('Featured image')" />
                                <div class="relative aspect-video rounded border overflow-hidden">
                                    @if ($primaryImage)
                                        <img src="{{ $primaryImage->preview_url }}" class="w-full h-full object-cover">
                                        <button wire:click="removePrimaryImage" type="button"
                                            class="btn btn-red p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full absolute top-2 start-2"
                                            aria-label="{{ __('Remove') }}">
                                            <i wire:loading.remove wire:target="removePrimaryImage"
                                                class="icon bi-trash"></i>
                                            <i class="icon fg-loader-dots-move text-white" wire:loading
                                                wire:target="removePrimaryImage"></i>
                                        </button>
                                    @endif
                                    <button wire:click="editPrimaryImage" type="button"
                                        class="btn btn-primary p-0 space-x-0 inline-flex items-center justify-center w-10 h-10 rounded-full absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"
                                        aria-label="{{ __('Edit') }}">
                                        <i wire:loading.remove wire:target="editPrimaryImage"
                                            class="icon bi-pencil-square"></i>
                                        <i class="icon fg-loader-dots-move text-white" wire:loading
                                            wire:target="editPrimaryImage"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col">
                                <livewire:components.select-user key="user-{{ $user_id ?? 'no' }}"
                                    wire:model.live="user_id"
                                    label="{{ __('User') }}" user="{{ $user_id }}" />
                                {{-- <x-rich-select id="user_id" wire:model.live="user_id" :label="__('User')"
                                    :placeholder="__('Select user')"
                                    :options="user_options(['selected' => $user_id])"
                                    :ajax-url="route('api.users')" :selected="$user_id" /> --}}
                            </div>
                            <div class="col">
                                <livewire:components.select-author key="author-{{ $author_id ?? 'no' }}"
                                    wire:model.live="author_id" :label="__('Author')" />
                                <a target="_blank" href="{{ route('dashboard.authors.create') }}"
                                    class="link flex-space-2 text-sm mt-2">
                                    @icon('fg-plus')
                                    <span>{{ __('Create new author') }}</span>
                                </a>
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="views" wire:model.live="views"
                                    :label="__('Views')" />
                            </div>
                            <div class="col">
                                <fgx:textarea id="excerpt" wire:model.live="excerpt" :label="__('Excerpt')" />
                            </div>
                            <div class="col">
                                <fgx:input type="text" id="seo_title" wire:model.live="seo_title"
                                    :label="__('Seo title')" />
                            </div>
                            <div class="col">
                                <fgx:textarea id="seo_description" wire:model.live="seo_description"
                                    :label="__('Seo description')" />
                            </div>
                            <div class="col">
                                <x-select-categories class="text-xs" model="categories" id="categories"
                                    :label="__('Categories')" :categories="get_categories()" :value="$categories" />
                            </div>
                            <div class="col">
                                <x-select-choice model="tags" wire:model.live="tags" class="select-custom"
                                    :placeholder="__('Select tags')" :label="__('Tags')" :options="tag_options($tags)" :choices="$tags" />
                            </div>
                            <div class="col">
                                <fgx:radio id="template" wire:model.live="template" :label="__('Template')"
                                    :options="template_options()" />
                            </div>
                            <div class="col">
                                <fgx:radio id="status" wire:model.live="status" :label="__('Status')"
                                    :options="status_options()" />
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary w-full">
                                    <i class="icon bi-floppy"></i>
                                    <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                                    <fgx:loader wire:loading wire:target="save" />
                                </button>
                                <fgx:status id="save" class="mt-2 xs alert-soft" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Column 2 -->
        </div>
    </form>

    <livewire:components.select-quote-image
        wire:model.live="{{ data_get($selectImages, 'model') }}"
        :label="data_get($selectImages, 'label')"
        :multiple="data_get($selectImages, 'multiple')"
        :show="data_get($selectImages, 'show', false)"
        wire:key="{{ data_get($selectImages, 'key') }}" />

</div>
