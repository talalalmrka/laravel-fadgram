<div>
    <x-slot name="actions">
        @if (route_has('dashboard.quotes'))
            <a wire:navigate href="{{ route('dashboard.books') }}" class="btn btn-blue btn-xs pill w-20">
                <i class="icon bi-list-ul"></i>
                <span>{{ __('All') }}</span>
            </a>
        @endif

        @if (method_exists($this, 'saved') && $this->saved() && route_has('dashboard.books.create'))
            <a wire:navigate href="{{ route('dashboard.books.create') }}" class="btn btn-emerald btn-xs pill w-20">
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
                                    <a href="{{ $book->permalink }}" target="_blank"
                                        class="link text-sm flex-space-2 mt-2">
                                        <i class="icon bi-box-arrow-up-right"></i>
                                        <span>{{ $book->permalink }}</span>
                                    </a>
                                @endif
                            </div>
                            <div class="col">
                                <fgx:input wire:model.live="slug" id="slug" :label="__('Slug')" autofocus />
                            </div>
                            <div class="col">
                                <fgx:file wire:model.live="file" id="file" :label="__('File')"
                                    :previews="$previewsFile" accept="application/pdf" />
                            </div>
                            <div class="col">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div class="col">
                                        <fgx:input id="year" wire:model.live="year"
                                            :label="__('Publish year')" />
                                    </div>
                                    <div class="col">
                                        <fgx:input type="number" id="pages" wire:model.live="pages"
                                            :label="__('Pages')" />
                                    </div>
                                    <div class="col">
                                        <fgx:input type="number" id="downloads" wire:model.live="downloads"
                                            :label="__('Downloads')" />
                                    </div>
                                    <div class="col">
                                        <fgx:input type="number" id="reads" wire:model.live="reads"
                                            :label="__('Reads')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <fgx:editor wire:model.live="content" id="content" :label="__('Content')"
                                    :value="$content" />
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
                                <fgx:file id="thumbnail" wire:model.live="thumbnail" :label="__('Featured image')"
                                    :previews="$previewsThumbnail" />
                            </div>
                            <div class="col">
                                <x-rich-select id="user_id" wire:model.live="user_id" :label="__('User')"
                                    :placeholder="__('Select user')"
                                    :options="user_options(['selected' => $user_id])"
                                    :ajax-url="route('api.users')" :selected="$user_id" />
                            </div>
                            <div class="col">
                                <x-rich-select id="author_id" wire:model.live="author_id" :label="__('Author')"
                                    :placeholder="__('Select author')"
                                    :options="author_options(['selected' => $author_id])"
                                    ajaxUrl="{{ route('api.authors') }}" :selected="$author_id" />

                                <a target="_blank" href="{{ route('dashboard.authors.create') }}"
                                    class="link flex-space-2 text-sm mt-2">
                                    @icon('fg-plus')
                                    <span>{{ __('Create new author') }}</span>
                                </a>
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
                                    :options="[
                                        [
                                            'label' => __('Draft'),
                                            'value' => 'draft',
                                        ],
                                        [
                                            'label' => __('Publish'),
                                            'value' => 'publish',
                                        ],
                                        [
                                            'label' => __('Trash'),
                                            'value' => 'trash',
                                        ],
                                    ]" />
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
</div>
