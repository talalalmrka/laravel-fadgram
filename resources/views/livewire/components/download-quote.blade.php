@if ($quote)
    <div wire:cloak
        class="rounded-xl shadow-sm relative overflow-hidden max-w-screen-md mx-auto">
        <figure class="post-featured-image relative">
            @if ($image)
                <img data-src="{{ $image->generatedImage($quote->id, 'md', 'webp') }}" alt="{{ $quote->content }}"
                    class="lozad w-full object-cover">
            @endif
            <div class="absolute top-0 inset-x-0 p-2 flex flex-space-2">
                <a
                    class="btn btn-blue p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                    wire:click="downloadImage"
                    aria-label="{{ __('Download') }}" title="{{ __('Download') }}">
                    <i class="icon bi-cloud-download"></i>
                </a>
                <a href=""
                    class="btn btn-rose p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full"
                    wire:click="shuffleImages"
                    aria-label="{{ __('Shuffle') }}">
                    <i wire:loading.remove wire:target="shuffleImages" class="icon bi-shuffle"></i>
                    <i class="icon fg-loader-dots-move text-white" wire:loading wire:target="shuffleImages"></i>
                </a>
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
                        wire:key="image-{{ $img->id }}">
                        <a wire:navigate href="{{ route('quote', ['quote' => $quote, 'img' => $img->id]) }}">
                            <img class="lozad w-full h-full object-cover" data-src="{{ $img->preview_url }}">
                            @if ($img->id === $image->id)
                                <i
                                    class="absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2 icon bi-check2-circle text-4xl text-white"></i>
                            @endif
                            <i wire:loading wire:target="selectImage({{ $img->id }})"
                                class="icon fg-loader-dots-move text-4xl text-white absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"></i>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @script
        <script>
            $js('lozad', () => {
                console.log('lozad')
                /* const observer = lozad('.lozad', {
                    rootMargin: '10px 0px', // syntax similar to that of CSS Margin
                    threshold: 0.1, // ratio of element convergence
                    enableAutoReload: true // it will reload the new image when validating attributes changes
                });
                observer.observe(); */
            })
        </script>
    @endscript
@endif
