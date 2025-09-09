@props([
    'title' => null,
    'show_title' => true,
    'class' => null,
    'atts' => [],
    'quotes' => null,
    'today' => today_formatted(),
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
    @if ($show_title && $title)
        <x-heading-strip :title="__($title, ['today' => $today])" />
    @endif

    @if ($quotes && $quotes->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- First card on the left, spanning 2 columns --}}
            @if ($quotes->isNotEmpty())
                @php $first = $quotes->first(); @endphp
                <div class="col">
                    <div class="card quote-{{ $first->id }} relative">
                        <div class="relative aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
                            <a href="{{ $first->permalink }}" title="{{ $first->name }}"
                                class="relative leading-none w-full h-full overflow-hidden group">
                                <img class="w-full h-auto object-cover opacity-0 transition-opacity duration-300"
                                    src="{{ $first->getThumbnailUrl('md') }}" loading="lazy"
                                    alt="{{ $first->content }}" onload="this.classList.remove('opacity-0')">

                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-black/30 via-transparent to-black/30 opacity-60">
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <a class="hover:link" href="{{ $first->permalink }}" title="{{ __('View quote') }}">
                                <p>{{ $first->content }}</p>
                            </a>
                            <div class="flex-space-2 text-sm">
                                @if ($first->category())
                                    <a href="{{ $first->category_permalink }}"
                                        class="text-muted hover:link flex-space-1">
                                        @icon('bi-folder')
                                        <span>{{ $first->category_name }}</span>
                                    </a>
                                @endif
                                @if ($first->author)
                                    <a href="{{ $first->author_permalink }}"
                                        class="text-muted hover:link flex-space-1">
                                        @icon('bi-person')
                                        <span>{{ $first->author_name }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Right column with stacked other cards --}}
            <div class="col flex flex-col gap-4">
                @foreach ($quotes->skip(1) as $quote)
                    <div class="card quote-{{ $quote->id }}">
                        <div class="card-body">
                            <a class="hover:link" href="{{ $quote->permalink }}" title="{{ __('View quote') }}">
                                <p>{{ $quote->content }}</p>
                            </a>
                            <div class="flex-space-2 text-sm">
                                @if ($quote->category())
                                    <a href="{{ $quote->category_permalink }}"
                                        class="text-muted hover:link flex-space-1">
                                        @icon('bi-folder')
                                        <span>{{ $quote->category_name }}</span>
                                    </a>
                                @endif
                                @if ($quote->author)
                                    <a href="{{ $quote->author_permalink }}"
                                        class="text-muted hover:link flex-space-1">
                                        @icon('bi-person')
                                        <span>{{ $quote->author_name }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <fgx:alert :content="__('No quotes today')" soft />
    @endif
</div>
