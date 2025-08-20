<div>
    <x-slot name="actions">
        @if (route_has('dashboard.pages'))
            <a wire:navigate href="{{ route('dashboard.pages') }}" class="btn btn-blue btn-xs pill w-20">
                <i class="icon bi-list-ul"></i>
                <span>{{ __('All') }}</span>
            </a>
        @endif

        @if (method_exists($this, 'saved') && $this->saved() && route_has('dashboard.pages.create'))
            <a wire:navigate href="{{ route('dashboard.pages.create') }}" class="btn btn-emerald btn-xs pill w-20">
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
                                    <a href="{{ $post->permalink }}" target="_blank"
                                        class="link text-sm flex-space-2 mt-2">
                                        <i class="icon bi-box-arrow-up-right"></i>
                                        <span>{{ $post->permalink }}</span>
                                    </a>
                                @endif
                            </div>
                            <div class="col">
                                <fgx:input wire:model.live="slug" id="slug" :label="__('Slug')" autofocus />

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
</div>
