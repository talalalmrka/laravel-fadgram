@props(['quote', 'share_enabled' => get_option('share_enabled'), 'class' => null, 'atts' => []])
<div x-data="{
    quoteId: @js($quote->id),
    share: false,
    favorite: @js($quote->isFavorited()),
    toggleFavorite() {
        this.favorite = !this.favorite;
        $wire.toggleFavorite(this.quoteId)
    }
}"
    {{ $attributes->merge(
        array_merge(
            [
                'wire:key' => $quote->id,
                'id' => "quote-{$quote->id}",
                'class' => css_classes([
                    'card relative rounded-3xl shadow-sm hover:shadow hover:scale-[1.03] transition-all duration-300',
                    "quote-{$quote->id}",
                    $class => $class,
                ]),
            ],
            $atts,
        ),
    ) }}>
    <div class="relative aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
        <a href="{{ $quote->permalink }}" title="{{ $quote->name }}"
            class="relative leading-none w-full h-full overflow-hidden group">
            <img class="w-full h-full object-cover"
                src="{{ $quote->getThumbnailUrl('sm') }}"
                alt="{{ $quote->name }}">
            <div class="absolute z-1 inset-0 bg-gradient-to-r from-black/30 via-transparent to-black/30 opacity-60">
            </div>
        </a>
        @if ($quote->category())
            <a href="{{ $quote->category_permalink }}" title="{{ $quote->category_name }}"
                class="badge pill badge-primary absolute top-2 start-2 z-2">
                {{ $quote->category_name }}
            </a>
        @endif
        <button type="button"
            class="btn btn-blue p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full absolute bottom-2 end-2 z-1"
            wire:click="downloadQuote({{ $quote->id }})" aria-label="Download">
            <i wire:loading.remove wire:target="downloadQuote({{ $quote->id }})" class="icon bi-cloud-download"></i>
            <i class="icon fg-loader-dots-move text-white" wire:loading
                wire:target="downloadQuote({{ $quote->id }})"></i>
        </button>
    </div>
    <div class="card-body flex flex-col">
        <a href="{{ $quote->permalink }}"
            class="text-center hover:link-no-underline flex-1">
            <p class="text-lg md:text-xl font-serif italic leading-relaxed tracking-wide">
                <i class="icon bi-quote text-primary dark:text-primary-400"></i>
                {{ $quote->getExcerpt(100) }}
                <i class="icon bi-quote text-primary dark:text-primary-400 rotate-180"></i>
            </p>
        </a>
        <div
            class="flex-space-2 justify-between border-t text-xs text-muted pt-2 mt-2 truncate flex-nowrap overflow-hidden">
            <div class="flex-space-2 flex-1 truncate flex-nowrap overflow-hidden">
                @if ($quote->author)
                    <a href="{{ $quote->author_permalink }}" title="{{ $quote->author_name }}"
                        class="flex-space-1 overflow-hidden">
                        @icon('bi-person')
                        <span class="truncate overflow-hidden whitespace-nowrap">{{ $quote->author_name }}</span>
                    </a>
                @endif
                <span class="flex-space-1 overflow-hidden">
                    @icon('bi-clock')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $quote->date_ago }}</span>
                </span>
                <span class="flex-space-1 overflow-hidden">
                    @icon('bi-eye')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $quote->views_formatted }}</span>
                </span>
            </div>
            <button type="button" x-on:click="toggleFavorite"
                class="text-lg flex-space-1">
                <i class="icon"
                    :class="{ 'bi-heart-fill text-red': favorite, 'bi-heart': !favorite }"></i>
            </button>
        </div>
    </div>
    <x-share-buttons :post="$quote" />
</div>
