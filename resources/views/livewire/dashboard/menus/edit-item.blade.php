<x-edit-dialog :model="$item" :title="$title">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col md:col-span-3">
            <fgx:input id="name" wire:model.live="name" class="sm" :label="__('Name')" />
        </div>
        <div class="col">
            <fgx:icon-picker id="icon" wire:model.live="icon" size="sm" :label="__('Icon')"
                value="{{ $icon }}" wire:key="item-icon-{{ $item->id }}" />
        </div>
        <div class="col">
            <fgx:input id="class_name" wire:model.live="class_name" class="sm" :label="__('Css classes')"
                :placeholder="__('Css classes')" />
        </div>
        <div class="col">
            <fgx:select id="type" wire:model.live="type" class="sm" :label="__('Type')"
                :options="menu_item_type_options()" />
        </div>

        <div class="col md:col-span-3" wire:show="type === 'page'">
            <fgx:select id="page_id" wire:model.live="page_id" class="sm" :label="__('Page')"
                :options="page_options()" />
        </div>
        <div class="col md:col-span-3" wire:show="type === 'post'">
            <fgx:select id="post_id" wire:model.live="post_id" class="sm" :label="__('Post')"
                :options="post_options()" />
        </div>
        <div class="col md:col-span-3" wire:show="type === 'category'">
            <fgx:select id="category_id" wire:model.live="category_id" class="sm" :label="__('Category')"
                :options="category_options()" />
        </div>
        <div class="col md:col-span-3" wire:show="type === 'custom'">
            <fgx:input id="url" wire:model.live="url" class="sm" :label="__('Url')" />
        </div>
        <div class="col">
            <fgx:switch id="navigate" wire:model.live="navigate" class="sm" :label="__('Navigate')" />
        </div>
        <div class="col">
            <fgx:switch id="new_tab" wire:model.live="new_tab" class="sm" :label="__('Open in new tab')" />
        </div>
        <div class="col">
            <button wire:click="delete" type="button"
                class="text-xs text-red dark:text-red-500 hover:underline flex-space-1">
                <i class="icon bi-trash-fill"></i>
                <span wire:loading.remove wire:target="delete">{{ __('Remove') }}</span>
                <fgx:loader wire:loading wire:target="delete" />
            </button>
        </div>
    </div>
</x-edit-dialog>
