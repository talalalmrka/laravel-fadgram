<x-dialog :title="$label" class="lg" body-class="p-0">
    <div x-tabs data-active="{{ $tab }}">
        <div x-tabs-header class="px-3">
            <button x-tab="images" class="flex-space-1" wire:click="$set('tab', 'images')">
                @icon('bi-image')
                <span>{{ __('Quote images') }}</span>
            </button>
            <button x-tab="create" class="flex-space-1" wire:click="$set('tab', 'create')">
                @icon('bi-upload')
                <span>{{ __('Create new') }}</span>
            </button>
        </div>
        <div x-tabs-content>
            <div x-tab-panel="images">
                <div class="sticky top-0 p-2 border-b bg-body-bg dark:bg-body-bg-dark z-1">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col">
                            <fgx:select id="filters.perPage" wire:model.live="filters.perPage"
                                :options="$perPageOptions"
                                class="sm" />
                        </div>
                        <div class="col">
                            <fgx:select id="filters.sort" wire:model.live="filters.sort" :options="$sortOptions"
                                class="sm" />
                        </div>
                        <div class="col">
                            <fgx:select id="filters.category" wire:model.live="filters.category"
                                :options="__('Category')" :options="$categoryOptions" class="sm" />
                            {{-- <x-rich-select id="filters.category" wire:model.live="filters.category" class="sm"
                                :placeholder="__('Category')"
                                :options="$categoryOptions"
                                :selected="data_get($filters, 'category')" /> --}}
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    @if ($images && $images->isNotEmpty())
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-2">
                            @foreach ($images as $img)
                                <div class="col">
                                    <div wire:click="selectImage({{ $img->id }})"
                                        class="relative aspect-video overflow-hidden cursor-pointer rounded">
                                        <img src="{{ $img->preview_url }}" alt="{{ $img->id }}"
                                            class="w-full h-full object-cover">
                                        @if (
                                            ($multiple && is_array($selectedImages) && in_array($img->id, $selectedImages)) ||
                                                (!$multiple && $selectedImages === $img->id))
                                            <i
                                                class="icon bi-check2-circle text-3xl absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2 text-white"></i>
                                        @endif
                                        <i wire:loading wire:target="toggleImage({{ $img->id }})"
                                            class="icon fg-loader-dots-move text-3xl absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2 text-white"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="py-3">
                            {!! $images->links() !!}
                        </div>
                    @else
                        <fgx:alert :content="__('No images found')" />
                    @endif
                </div>
            </div>
            <div x-tab-panel="create" class="px-3">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-100 relative">
                    <div class="col md:col-span-2 relative">
                        <img src="{{ $reviewUrl }}" alt="" class="max-w-full mx-auto">
                    </div>
                    <div class="col h-full overflow-y-auto">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col col-span-2">
                                <fgx:file id="newImage" wire:model.live="newImage" :label="__('Image')"
                                    :previews="$previewsNewImage" />
                            </div>
                            <div class="col">
                                <x-select-choice model="categories" wire:model.live="categories" class="select-custom"
                                    :placeholder="__('Select categories')" :label="__('Categories')" :options="category_choices_options($categories)" :choices="$categories" />
                            </div>
                            <div class="col">
                                <fgx:select id="font_id" wire:model.live="font_id" :label="__('Font')"
                                    :options="font_options()" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="width" wire:model.live="width"
                                    :label="__('Width')" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="height" wire:model.live="height"
                                    :label="__('Height')" />
                            </div>
                            <div class="col">
                                <fgx:input type="color" id="color" wire:model.live="color" class="p-0 w-10 h-10"
                                    :label="__('Color')" />
                            </div>
                            <div class="col">
                                <fgx:input type="color" id="border_color" wire:model.live="border_color"
                                    class="p-0 w-10 h-10"
                                    :label="__('Border color')" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="border_width" wire:model.live="border_width"
                                    :label="__('Border width')" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="min_font" wire:model.live="min_font"
                                    :label="__('Min font')" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="max_font" wire:model.live="max_font"
                                    :label="__('Max font')" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" step="0.1" id="spacing" wire:model.live="spacing"
                                    :label="__('Spacing')" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="max_lines" wire:model.live="max_lines"
                                    :label="__('Max lines')" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" id="padding" wire:model.live="padding"
                                    :label="__('Padding')" />
                            </div>
                            <div class="col">
                                <fgx:select id="align" wire:model.live="align" :label="__('Align')"
                                    :options="align_options()" />
                            </div>
                            <div class="col">
                                <fgx:select id="valign" wire:model.live="valign" :label="__('Vertical align')"
                                    :options="valign_options()" />
                            </div>
                            <div class="col">
                                <fgx:input type="number" min="0" max="100" id="blur"
                                    wire:model.live="blur"
                                    :label="__('Blur')" />
                            </div>
                            <div class="col">
                                <fgx:select id="format" wire:model.live="format" :label="__('Format')"
                                    :options="image_format_options()" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <div class="modal-footer flex-space-2 justify-end">
            <button type="button" class="btn btn-secondary btn-sm" x-on:click="closeModal">
                {{ __('Close') }}
            </button>
            <button x-show="$wire.tab === 'images'" wire:click="done" type="button"
                class="btn btn-primary btn-sm" {{ $disabledDone ? 'disabled' : '' }}>
                <i class="icon bi-check"></i>
                <span wire:loading.remove wire:target="done">{{ __('Done') }}</span>
                <fgx:loader wire:loading wire:target="done" />
            </button>
            <button x-show="$wire.tab == 'create'" wire:click="create" type="button"
                class="btn btn-primary btn-sm" {{ $disabledCreate ? 'disabled' : '' }}>
                <i class="icon bi-check"></i>
                <span wire:loading.remove wire:target="create">{{ __('Create') }}</span>
                <fgx:loader wire:loading wire:target="create" />
            </button>
        </div>
    </x-slot>
    <x-slot name="after">
        @teleport('body')
            <x-crop-image-dialog />
        @endteleport
    </x-slot>
</x-dialog>
