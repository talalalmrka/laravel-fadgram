@props(['book', 'share_enabled' => get_option('share_enabled'), 'class' => null, 'atts' => []])
<div x-data="{
    bookId: @js($book->id),
    share: false,
    favorite: @js($book->isFavorited()),
    toggleFavorite() {
        this.favorite = !this.favorite;
        $wire.toggleFavorite(this.bookId)
    }
}"
    {{ $attributes->merge(
        array_merge(
            [
                'wire:key' => $book->id,
                'id' => "book-{$book->id}",
                'class' => css_classes([
                    'card relative rounded-3xl shadow-sm hover:shadow hover:scale-[1.03] transition-all duration-300',
                    "book-{$book->id}",
                    $class => $class,
                ]),
            ],
            $atts,
        ),
    ) }}>
    <div
        class="relative w-full aspect-[3/4] bg-gray-200 flex items-center justify-center overflow-hidden">
        <a href="{{ $book->permalink }}" title="{{ $book->name }}"
            class="relative leading-none w-full h-full overflow-hidden group object-cover">
            <img class="w-full h-full object-cover group-hover:scale-[1.05] transition-all duration-300"
                src="{{ $book->getThumbnailUrl('sm') }}"
                alt="{{ $book->name }}">
            <div
                class="absolute z-1 inset-0 bg-gradient-to-r from-black/30 via-black/10 to-black/30 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                <i
                    class="icon bi-book text-white w-10 h-10 scale-50 group-hover:scale-100 transition-transform"></i>
            </div>
        </a>
        @if ($book->category())
            <a href="{{ $book->category_permalink }}" title="{{ $book->category_name }}"
                class="badge pill badge-primary absolute top-2 start-2 z-2">
                {{ $book->category_name }}
            </a>
        @endif
    </div>
    <div class="card-body flex flex-col">
        <div class="flex-1 text-center">
            <h2 class="text-lg font-semibold text-center mb-1.5">
                <a class="hover:link" href="{{ $book->permalink }}"
                    title="{{ $book->name }}">
                    {{ $book->name }}
                </a>
            </h2>
            <a href="{{ $book->author_permalink }}" title="{{ $book->author_name }}"
                class="inline-flex space-x-1 rtl:space-x-reverse items-center text-sm overflow-hidden mx-auto hover:link">
                @icon('bi-person')
                <span class="truncate overflow-hidden whitespace-nowrap">{{ $book->author_name }}</span>
            </a>
        </div>
        <div
            class="flex-space-2 justify-between border-t text-xs text-muted pt-2 mt-2 truncate flex-nowrap overflow-hidden">
            <div class="flex-space-2 flex-1 truncate flex-nowrap overflow-hidden">
                <span class="flex-space-1 overflow-hidden text-xs">
                    @icon('bi-clock')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $book->date_ago }}</span>
                </span>
                <span class="flex-space-1 overflow-hidden text-xs">
                    @icon('bi-book')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $book->reads_formatted }}</span>
                </span>
                <span class="flex-space-1 overflow-hidden text-xs">
                    @icon('bi-cloud-download')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $book->downloads_formatted }}</span>
                </span>
            </div>
            <button type="button" x-on:click="toggleFavorite"
                class="text-lg flex-space-1">
                <i class="icon"
                    :class="{ 'bi-heart-fill text-red': favorite, 'bi-heart': !favorite }"></i>
            </button>
        </div>
    </div>
    <x-share-buttons :post="$book" />
</div>
