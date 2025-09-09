@if ($quote)
<div class="rounded-xl shadow-sm relative overflow-hidden max-w-screen-md mx-auto">
    <figure class="post-featured-image relative">
        @if ($image)
        <img data-src="{{ $image->generatedImage($quote->id, 'md', 'webp') }}" alt="{{ $quote->name }}"
            class="lozad w-full object-cover aspect-[16/9]">
        @endif

        <div class="absolute top-0 inset-x-0 p-2 flex flex-space-2">
            <button type="button"
                class="btn btn-blue p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                wire:click="downloadImage"
                aria-label="{{ __('Download') }}">
                <i wire:loading.remove wire:target="downloadImage" class="icon bi-cloud-download"></i>
                <i class="icon fg-loader-dots-move text-white" wire:loading wire:target="downloadImage"></i>
            </button>
            <button type="button"
                class="btn btn-rose p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                wire:click="shuffleImages"
                aria-label="{{ __('Shuffle') }}">
                <i wire:loading.remove wire:target="shuffleImages" class="icon bi-shuffle"></i>
                <i class="icon fg-loader-dots-move text-white" wire:loading wire:target="shuffleImages"></i>
            </button>
            @if ($shuffle)
            <button type="button"
                class="btn btn-purple p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                wire:click="loadImages"
                aria-label="{{ __('Reset') }}">
                <i wire:loading.remove wire:target="loadImages" class="icon bi-arrow-counterclockwise"></i>
                <i class="icon fg-loader-dots-move text-white" wire:loading wire:target="loadImages"></i>
            </button>
            @endif
        </div>
        <i wire:loading wire:target="selectImage"
            class="icon fg-loader-dots-move text-4xl text-white absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"></i>

    </figure>
    <div class="grid grid-cols-5 border-t divide-x">
        @if ($images)
        @foreach ($images as $img)
        <div class="col relative overflow-hidden cursor-pointer"
            wire:click="selectImage({{ $img->id }})"
            wire:key="image-{{ $img->id }}">
            <img class="lozad w-full h-full object-cover" data-src="{{ $img->preview_url }}">
            @if ($img->id === $image->id)
            <i
                class="absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2 icon bi-check2-circle text-4xl text-white"></i>
            @endif
            <i wire:loading wire:target="selectImage({{ $img->id }})"
                class="icon fg-loader-dots-move text-4xl text-white absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"></i>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endif