<div wire:init="loadEdit">
    <fgx:card>
        <div class="p-2 md:flex-space-2 justify-between">
            <button type="button" wire:click="resetTable" wire:confirm="{{ __('Are you shure to reset table?') }}"
                class="btn btn-red btn-xs pill">
                <i class="icon bi-arrow-repeat"></i>
                <span>{{ __('Reset table') }}</span>
            </button>
            <fgx:status />
        </div>
        {!! $this->table() !!}
    </fgx:card>
    <livewire:dashboard.quote-images.edit wire:key="edit-quote-image" />
</div>
