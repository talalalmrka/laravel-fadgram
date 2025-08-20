<div>
    <fgx:card>
        <div class="grid grid-cols-3 gap-4 p-3">
            <div class="col">
                <x-rich-select id="user_id" wire:model.live="user_id" :label="__('Author')" :placeholder="__('All')" size="sm"
                    :options="user_options(['selected' => $user_id])" ajaxUrl="{{ route('api.users') }}" :selected="$user_id" />
            </div>
            <div class="col">
                <fgx:select id="category_id" wire:model.live="category_id" :label="__('Category')" class="sm"
                    :options="category_options(__('All'))" />
            </div>
            <div class="col">
                <fgx:select id="publish_status" wire:model.live="publish_status" :label="__('Status')" class="sm"
                    :options="status_options(__('All'))" />
            </div>
        </div>
        {!! $this->table() !!}
    </fgx:card>
</div>
