<fgx:label for="images" :label="__('Images')" />

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
    @if ($quoteImages && $quoteImages->isNotEmpty())
        @foreach ($quoteImages as $img)
            <div class="col">
                <div
                    class="relative aspect-video overflow-hidden cursor-pointer rounded border">
                    <img src="{{ $img->preview_url }}" alt="{{ $img->id }}"
                        class="w-full h-full object-cover">
                    <button wire:click="removeImage({{ $img->id }})" type="button"
                        class="btn btn-red p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full absolute top-2 start-2"
                        aria-label="{{ __('Remove') }}">
                        <i wire:loading.remove wire:target="removeImage({{ $img->id }})" class="icon bi-trash"></i>
                        <i class="icon fg-loader-dots-move text-white" wire:loading
                            wire:target="removeImage({{ $img->id }})"></i>
                    </button>
                </div>
            </div>
        @endforeach
    @endif
    <div class="col">
        <div wire:click="addImage"
            class="relative aspect-video overflow-hidden cursor-pointer rounded flex items-center justify-center bg-gray-100 dark:bg-gray-700 border hover:shadow-sm text-muted hover:text-inherit">
            <i wire:loading.remove wire:target="addImage"
                class="icon fg-plus text-2xl absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"></i>
            <i wire:loading wire:target="addImage"
                class="icon fg-loader-dots-move absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"></i>
        </div>

    </div>
</div>
