<form wire:submit="create">
    <fgx:card>
        <fgx:card-body>
            <fgx:label for="name" :label="__('Create menu')" />
            <div class="input-group sm flex justify-between w-full">
                <input type="text" wire:model.live="name"
                    class="form-control grow {{ $errors->has('name') ? 'error' : '' }}"
                    placeholder="{{ __('Menu name') }}">
                <button type="submit" class="btn btn-primary justify-center w-[90px]">
                    <i class="icon fg-plus"></i>
                    <span wire:loading.remove wire:target="create">{{ __('Create') }}</span>
                    <fgx:loader wire:loading wire:target="create" />
                </button>
            </div>
            <fgx:error id="name" />
            <fgx:status class="alert-soft xs mt-2" />
        </fgx:card-body>
    </fgx:card>
</form>
