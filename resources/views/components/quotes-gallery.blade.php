@props([
    'title' => null,
    'class' => null,
    'atts' => [],
    'quotes' => null,
])
<div
    {{ $attributes->merge(
        array_merge(
            [
                'class' => css_classes([
                    $class => $class,
                ]),
            ],
            $atts,
        ),
    ) }}>
    @if ($title)
        <x-heading-strip :title="$title" />
    @endif
    @if ($quotes && $quotes->isNotEmpty())
        <div class="masonry-columns columns-1 sm:columns-2 md:columns-3 gap-6">
            @foreach ($quotes as $quote)
                <!-- Each item -->
                <div class="masonry-item relative mb-6 group rounded-2xl overflow-hidden">
                    <a href="{{ $quote->permalink }}" title="{{ $quote->content }}">
                        <img
                            src="{{ $quote->getThumbnailUrl('sm') }}" loading="lazy"
                            alt="{{ $quote->content }}"
                            class="w-full rounded-2xl shadow-lg opacity-0 transition-opacity duration-300"
                            onload="this.classList.remove('opacity-0')" />
                        <div class="absolute inset-0 hidden group-hover:block rounded-2xl bg-black/30"></div>
                    </a>
                    <a href="{{ $quote->download_url }}"
                        class="btn btn-blue p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full absolute bottom-2 end-2 z-1"
                        title="Download">
                        <i class="icon bi-cloud-download"></i>
                    </a>
                    @if ($quote->categories)
                        <div class="absolute bottom-2 inset-x-2 gap-4 flex-wrap hidden group-hover:flex">
                            {!! $quote->categoriesLinks([
                                'class' => 'text-sm pill bg-primary/70 text-white px-2 py-1',
                            ]) !!}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @if (method_exists($quotes, 'links'))
            <div class="mt-3">{{ $posts->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No quotes found')" soft />
    @endif
</div>
