<div>
    <div x-data="fgSort">
        <div class="md:flex-space-2 justify-between">
            <h5 class="mb-4">{{ __('Menu structure') }}</h5>
            <fgx:loader wire:loading wire:target="updateItemOrder" />
            <fgx:status id="order_status" class="alert-outline p-0 bg-transparent border-0" />
        </div>
        @if ($items->isEmpty())
            <fgx:alert soft :content="__('No items found')" />
        @endif
        <div x-sort x-sort.ghost x-sort:group="nested" x-sort:config="sortConfig" data-parent="null" class="sort">
            @if ($items->isNotEmpty())
                @foreach ($items as $item)
                    <x-menu-item :item="$item" />
                @endforeach
            @endif
        </div>
    </div>
    @if ($editItem)
        <livewire:dashboard.menus.edit-item :item="$editItem" wire:key="edit-item-{{ $editItem->id ?? uniqid() }}" />
    @endif
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
