<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="col">
        <h5>{{ __('Add menu items') }}</h5>
        <fgx:accordion>
            <!-- Pages -->
            <fgx:accordion-item name="pages" :title="__('Pages')" icon="bi-file-earmark-text">
                @foreach (page_options() as $i => $option)
                    <fgx:checkbox id="pages-{{ $i }}" class="cursor-pointer" wire:model.live="pages"
                        :label="data_get($option, 'label')" :value="data_get($option, 'value')" />
                @endforeach
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
                <fgx:status id="pages_status" class="mt-2" />
            </fgx:accordion-item>
            <!-- Posts -->
            <fgx:accordion-item name="posts" :title="__('Posts')" icon="bi-newspaper">
                @foreach (post_options() as $i => $option)
                    <fgx:checkbox id="posts-{{ $i }}" class="cursor-pointer" wire:model.live="posts"
                        :label="data_get($option, 'label')" :value="data_get($option, 'value')" />
                @endforeach
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
                <fgx:status id="posts_status" class="mt-2" />
            </fgx:accordion-item>
            <!-- Categories -->
            <fgx:accordion-item name="categories" :title="__('Categories')" icon="bi-folder-fill">
                @foreach (category_options() as $i => $option)
                    <fgx:checkbox id="categories-{{ $i }}" class="cursor-pointer"
                        wire:model.live="categories" :label="data_get($option, 'label')"
                        :value="data_get($option, 'value')" />
                @endforeach
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
            </fgx:accordion-item>
            <!-- Custom -->
            <fgx:accordion-item name="custom" :title="__('Custom links')" icon="bi-link-45deg">
                <form wire:submit="addCustom">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="col">
                            <fgx:input id="custom.name" wire:model.live="custom.name" class="sm"
                                :label="__('Name')" />
                        </div>
                        <div class="col">
                            <fgx:icon-picker id="custom.icon" wire:model.live="custom.icon" class="sm"
                                :label="__('Icon')" :value="data_get($custom, 'icon')" />
                        </div>
                        <div class="col">
                            <fgx:input id="custom.url" wire:model.live="custom.url" class="sm"
                                :label="__('Url')" />
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
            </fgx:accordion-item>
        </fgx:accordion>
    </div>
    <div x-data="fgSort" class="col md:col-span-2">
        <div class="md:flex-space-2 justify-between">
            <h5 class="mb-4">{{ __('Menu structure') }}</h5>
            <fgx:loader wire:loading wire:target="updateItemOrder" />
            <fgx:status id="order_status" class="alert-outline p-0 bg-transparent border-0" />
        </div>
        <div x-sort x-sort.ghost x-sort:group="nested" x-sort:config="sortConfig" data-parent="null" class="sort">
            @if ($items->isNotEmpty())
                @foreach ($items as $item)
                    <x-menu-item :item="$item" />

                    {{--
                    <livewire:dashboard.menus.edit-item :item="$item" wire:key="menu-item-{{ $item->id }}" />
                        --}}
                @endforeach
            @endif
        </div>
    </div>
    <livewire:dashboard.menus.edit-item wire:key="edit-item" />
</div>
@script
    <script>
        $js('refresh', () => {
            console.log('refresh');
            $wire.$refresh();
        });
        Alpine.data('fgSort', () => ({
            items: @entangle('items'),
            sortConfig() {
                return {
                    animation: 150,
                    fallbackOnBody: true,
                    //swapThreshold: 0.65,
                    onSort: function(evt) {
                        const from = evt.from;
                        const to = evt.to;
                        //console.log('from:', from, 'to:', to);
                        const itemId = evt.item.dataset.id;
                        const oldIndex = evt.oldIndex;
                        const oldParentId = from.dataset.parent;
                        const newIndex = evt.newIndex;
                        const newParentId = to.dataset.parent;
                        console.log('itemId:', itemId, 'oldIndex:', oldIndex, 'oldParentId:', oldParentId,
                            'newIndex:',
                            newIndex, 'newParentId:', newParentId);
                        $wire.updateItemOrder(itemId, oldIndex, oldParentId, newIndex, newParentId);
                    },
                };
            }
        }));
    </script>
@endscript
