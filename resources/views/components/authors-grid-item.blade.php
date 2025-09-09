@props(['author', 'share_enabled' => get_option('share_enabled'), 'class' => null, 'atts' => []])
<div x-data="{
    authorId: @js($author->id),
    share: false,
    favorite: @js($author->isFavorited()),
    toggleFavorite() {
        this.favorite = !this.favorite;
        $wire.toggleFavorite(this.authorId)
    }
}"
    {{ $attributes->merge(
        array_merge(
            [
                'wire:key' => $author->id,
                'id' => "author-{$author->id}",
                'class' => css_classes([
                    'card relative rounded-3xl shadow-sm hover:shadow transition-all duration-300',
                    "author-{$author->id}",
                    $class => $class,
                ]),
            ],
            $atts,
        ),
    ) }}>
    <div class="relative aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
        <a href="{{ $author->permalink }}" title="{{ $author->name }}"
            class="relative leading-none w-full h-full overflow-hidden group">
            <img class="lozad w-full h-full object-cover group-hover:scale-110 transition-all duration-300" loading="lazy"
                src="{{ $author->getThumbnailUrl('sm') }}"
                alt="{{ $author->name }}">
            <div
                class="absolute z-1 inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <i
                    class="icon bi-link-45deg text-white w-10 h-10 scale-50 group-hover:scale-100 transition-transform"></i>
            </div>
        </a>
        @if ($author->category())
            <a href="{{ $author->category_permalink }}" title="{{ $author->category_name }}"
                class="badge pill badge-primary absolute top-2 start-2">
                {{ $author->category_name }}
            </a>
        @endif
    </div>
    <div class="card-body flex flex-col">
        <h2 class="text-lg font-semibold text-center flex-1 mb-0 overflow-hidden truncate">
            <a class="text-inherit hover:text-primary hover:underline" href="{{ $author->permalink }}"
                title="{{ $author->name }}">
                {{ $author->name }}
            </a>
        </h2>
        <div
            class="flex-space-2 justify-between border-t text-xs text-muted pt-2 mt-2 truncate flex-nowrap overflow-hidden">
            <div class="flex-space-2 flex-1">
                <span class="flex-space-1 overflow-hidden">
                    @icon('bi-clock')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $author->date_ago }}</span>
                </span>
                <span class="flex-space-1 overflow-hidden">
                    @icon('bi-quote')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $author->quotes_count }}</span>
                </span>
                <span class="flex-space-1 overflow-hidden">
                    @icon('bi-book')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $author->books_count }}</span>
                </span>
            </div>
            <button type="button" x-data="{ favorite: false }" x-on:click="favorite = !favorite"
                class="text-lg flex-space-1">
                <i class="icon"
                    :class="{ 'bi-heart-fill text-red': favorite, 'bi-heart': !favorite }"></i>
            </button>
        </div>
    </div>
    <x-share-buttons :post="$author" />
</div>
