<div class="container py-6">
    <form wire:submit="save">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:file id="image" wire:model.live="image" :label="__('Image')" :previews="$previewsImage" />
                <pre>
                     @php
                         print_r($previewsImage);
                     @endphp
                </pre>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    <i class="icon bi-floppy"></i>
                    <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                    <fgx:loader wire:loading wire:target="save" />
                </button>
                <fgx:status class="alert-soft xs mt-2" />
            </div>
        </div>
    </form>

    <div class="">
        showCrop: {{ $showCrop }}
    </div>

    {{-- <x-crop-image-dialog :show-crop="$showCrop" /> --}}
</div>
