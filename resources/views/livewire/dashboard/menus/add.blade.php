<div>
    <h5>{{ __('Add menu items') }}</h5>
    <div x-accordion x-cloak>
        <div x-accordion-item>
            <div x-accordion-header>
                <div class="flex-space-2">
                    <i class="icon bi-file-earmark-text"></i>
                    <span>{{ __('Pages') }}</span>
                </div>
            </div>
            <div x-accordion-body>
                <div class="max-h-48 overflow-y-auto">
                    @foreach (page_options() as $i => $option)
                        <fgx:checkbox id="pages-{{ $i }}" class="cursor-pointer" wire:model.live="pages"
                            :label="data_get($option, 'label')" :value="data_get($option, 'value')" />
                    @endforeach
                </div>
                <div class="divider my-2"></div>
                <div class="flex-space-2 justify-between">
                    <fgx:checkbox id="pages-all" class="cursor-pointer" container_class="inline-flex"
                        wire:model.live="selectAllPages" :label="__('Select all')" />
                    <button wire:click="addPages" type="button" class="btn btn-primary xs text-nowrap"
                        {{ empty($pages) ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="addPages">{{ __('Add to menu') }}</span>
                        <fgx:loader wire:loading wire:target="addPages" />
                    </button>
                </div>
                <fgx:status soft id="pages_status" class="mt-2 text-sm" />
            </div>
        </div>
        <div x-accordion-item>
            <div x-accordion-item>
                <div x-accordion-header>
                    <div class="flex-space-2">
                        <i class="icon bi-newspaper"></i>
                        <span>{{ __('Posts') }}</span>
                    </div>
                </div>
                <div x-accordion-body>
                    <div class="max-h-48 overflow-y-auto">
                        @foreach (post_options() as $i => $option)
                            <fgx:checkbox id="posts-{{ $i }}" class="cursor-pointer" wire:model.live="posts"
                                :label="data_get($option, 'label')" :value="data_get($option, 'value')" />
                        @endforeach
                    </div>
                    <div class="divider my-2"></div>
                    <div class="flex-space-2 justify-between">
                        <fgx:checkbox id="posts-all" class="cursor-pointer" container_class="inline-flex"
                            wire:model.live="selectAllPosts" :label="__('Select all')" />
                        <button wire:click="addPosts" type="button" class="btn btn-primary xs text-nowrap"
                            {{ empty($posts) ? 'disabled' : '' }}>
                            <span wire:loading.remove wire:target="addPosts">{{ __('Add to menu') }}</span>
                            <fgx:loader wire:loading wire:target="addPosts" />
                        </button>
                    </div>
                    <fgx:status soft id="posts_status" class="mt-2 text-sm" />
                </div>
            </div>
        </div>
        <div x-accordion-item>
            <div x-accordion-item>
                <div x-accordion-header>
                    <div class="flex-space-2">
                        <i class="icon bi-folder-fill"></i>
                        <span>{{ __('Categories') }}</span>
                    </div>
                </div>
                <div x-accordion-body>
                    <fgx:input id="searchCategories" wire:model.live="searchCategories" class="xs pill"
                        endIcon="bi-search" placeholder="{{ __('Search') }}" />
                    <div class="max-h-48 overflow-y-auto">
                        <x-categories-list :categories="$this->categoryOptions" />
                    </div>
                    <div class="divider my-2"></div>
                    <div class="flex-space-2 justify-between">
                        <fgx:checkbox id="categories-all" class="cursor-pointer" container_class="inline-flex"
                            wire:model.live="selectAllCategories" :label="__('Select all')" />
                        <button wire:click="addCategories" type="button" class="btn btn-primary xs text-nowrap"
                            {{ empty($categories) ? 'disabled' : '' }}>
                            <span wire:loading.remove wire:target="addCategories">{{ __('Add to menu') }}</span>
                            <fgx:loader wire:loading wire:target="addCategories" />
                        </button>
                    </div>
                    <fgx:status id="categories_status" class="mt-2" />
                </div>
            </div>
        </div>
        <div x-accordion-item>
            <div x-accordion-item>
                <div x-accordion-header>
                    <div class="flex-space-2">
                        <i class="icon bi-link-45deg"></i>
                        <span>{{ __('Custom links') }}</span>
                    </div>
                </div>
                <div x-accordion-body>
                    <form wire:submit="addCustom">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="col">
                                <fgx:input id="custom.name" wire:model="custom.name" class="sm"
                                    :label="__('Name')" placeholder="{{ __('Name') }}" />
                            </div>
                            <div class="col">
                                <fgx:icon-picker id="custom.icon" wire:model="custom.icon" group_class="sm"
                                    :label="__('Icon')" placeholder="{{ __('Icon') }}"
                                    :value="data_get($custom, 'icon')" />
                            </div>
                            <div class="col">
                                <fgx:input id="custom.url" wire:model="custom.url" class="sm"
                                    :label="__('Url')" placeholder="{{ __('Url') }}" />
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary xs text-nowrap">
                                    <i class="icon fg-plus"></i>
                                    <span wire:loading.remove wire:target="addCustom">{{ __('Add to menu') }}</span>
                                    <fgx:loader wire:loading wire:target="addCustom" />
                                </button>
                                <fgx:status id="custom_status" soft sm class="mt-2" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
