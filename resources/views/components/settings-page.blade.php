@props([
    'showReset' => true,
])
<form wire:submit="save">
    {{ $slot }}
    <div class="sticky bottom-0 p-2 bg-white dark:bg-gray-700 border-t mt-4 z-10">
        <div class="flex justify-between">
            <div class="inline-flex space-x-2 rtl:space-x-reverse">
                <button type="submit" class="btn btn-primary">
                    <i class="icon bi-floppy"></i>
                    <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                    <fgx:loader wire:loading wire:target="save" />
                </button>
                <fgx:status class="alert-outline xs p-0 border-0" />
            </div>
            @if ($showReset)
                <div class="inline-flex space-x-2 rtl:space-x-reverse">
                    <fgx:status id="reset" class="alert-outline xs p-0 border-0" />
                    <button type="button" wire:click="resetSettings"
                        wire:confirm="{{ __('Are you sure to reset settings?') }}" class="btn btn-secondary">
                        <i class="icon bi-arrow-repeat"></i>
                        <span wire:loading.remove wire:target="resetSettings">{{ __('Reset settings') }}</span>
                        <fgx:loader wire:loading wire:target="resetSettings" />
                    </button>
                </div>
            @endif
        </div>
    </div>
</form>
@script
    <script>
        $js('refresh', () => {
            location.reload();
        })
    </script>
@endscript
