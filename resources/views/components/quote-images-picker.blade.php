@props(['quote'])
@php
    $images = $quote->images;
    $image = $images->first();
    $currentImage = $image->generatedImage($quote->id, 'md', 'webp');
    $fetchUrl = route('imgen.quote.random', ['quote' => $quote]);
    $imagesResponse = $quote->imagesResponse();
@endphp
<div x-data="QuoteImagesPicker({
    currentImage: @js($currentImage),
    fetchUrl: @js($fetchUrl),
    images: @js($imagesResponse),
})" class="rounded-xl shadow-sm relative overflow-hidden max-w-screen-md mx-auto">
    <figure class="post-featured-image relative">
        @if ($image)
            <img src="{{ $currentImage }}" loading="lazy" alt="{{ $quote->content }}"
                class="w-full aspect-video object-cover opacity-0 transition-opacity duration-300"
                onload="this.classList.remove('opacity-0')" x-bind="selectedImage">
        @endif
        <div class="absolute top-0 inset-x-0 p-2 flex flex-space-2">
            <a href="{{ $quote->getDownloadImageUrl($image) }}"
                class="btn btn-blue p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                x-bind="btnDownload"
                aria-label="{{ __('Download') }}" title="{{ __('Download') }}">
                <i class="icon bi-cloud-download"></i>
            </a>
            <button type="button" x-bind="btnShuffle"
                class="btn btn-rose p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                aria-label="{{ __('Shuffle') }}">
                <i x-show="!shuffling" class="icon bi-shuffle"></i>
                <i x-show="shuffling" class="icon fg-loader-dots-move text-white"></i>
            </button>
            <button x-show="shuffle" x-bind="btnReset" type="button"
                class="btn btn-purple p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                aria-label="{{ __('Reset') }}">
                <i x-show="!reseting" class="icon bi-arrow-counterclockwise"></i>
                <i x-show="reseting" class="icon fg-loader-dots-move text-white"></i>
            </button>
        </div>

    </figure>
    <div class="grid grid-cols-5 border-t divide-x">
        <template x-for="(img, i) in images" :key="img.source">
            <div class="col relative overflow-hidden cursor-pointer">
                <img x-bind="image"
                    class="w-full aspect-video object-cover opacity-0 transition-opacity duration-300"
                    :src="img.preview"
                    :data-source="img.source"
                    :data-download="img.download"
                    loading="lazy"
                    onload="this.classList.remove('opacity-0')">
                <i class="absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2
                          icon bi-check2-circle text-4xl text-white"
                    x-show="currentImage === img.source"></i>
            </div>
        </template>
    </div>
</div>
