<div>
    <fgx:card>
        {{ $this->table() }}
    </fgx:card>
    <livewire:dashboard.media.create wire:key="create-media" />
    <livewire:dashboard.media.edit wire:key="edit-media" />
    <livewire:dashboard.media.show wire:key="show-media" />
</div>
