@props(['category', 'share_enabled' => get_option('share_enabled'), 'class' => null, 'atts' => []])
<div x-data="{
    categoryId: @js($category->id),
    share: false,
    favorite: @js($category->isFavorited()),
    toggleFavorite() {
        this.favorite = !this.favorite;
        $wire.toggleFavorite('category', this.categoryId)
    }
}"
    {{ $attributes->merge(
        array_merge(
            [
                'wire:key' => $category->id,
                'id' => "category-{$category->id}",
                'class' => css_classes([
                    'card relative rounded-3xl shadow-sm hover:shadow hover:scale-[1.03] transition-all duration-300',
                    "category-{$category->id}",
                    $class => $class,
                ]),
            ],
            $atts,
        ),
    ) }}>
    <div class="relative aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
        <a href="{{ $category->permalink }}" title="{{ $category->name }}"
            class="relative leading-none w-full h-full overflow-hidden group">
            <img class="lozad w-full h-full object-cover group-hover:scale-110 transition-all duration-300"
                src="{{ $category->getThumbnailUrl('sm') }}" loading="lazy"
                alt="{{ $category->name }}">
            <div
                class="absolute z-1 inset-0 bg-gradient-to-r from-black/30 via-black/10 to-black/30 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                <i
                    class="icon bi-folder text-white w-10 h-10 scale-50 group-hover:scale-100 transition-transform"></i>
            </div>
        </a>
    </div>
    <div class="card-body flex flex-col">
        <h2 class="text-lg mb-2 font-semibold">
            <a class="hover:link-underline" href="{{ $category->permalink }}"
                title="{{ $category->name }}">
                {{ $category->name }}
            </a>
        </h2>
        @if (get_option('excerpt_enabled'))
            <p class="mb-0 text-base text-muted flex-1">
                {{ $category->excerpt }}
            </p>
        @endif
        <div
            class="flex-space-2 justify-between border-t text-xs text-muted pt-2 mt-2 truncate flex-nowrap overflow-hidden">
            <div class="flex-space-2 flex-1 truncate flex-nowrap overflow-hidden">
                @if ($category->posts_count)
                    <span class="flex-space-1 overflow-hidden">
                        @icon('bi-newspaper')
                        <span
                            class="truncate overflow-hidden whitespace-nowrap">{{ number_format($category->posts_count) }}</span>
                    </span>
                @endif
                @if ($category->quotes_count)
                    <span class="flex-space-1 overflow-hidden">
                        @icon('bi-quote')
                        <span
                            class="truncate overflow-hidden whitespace-nowrap">{{ number_format($category->quotes_count) }}</span>
                    </span>
                @endif
                @if ($category->books_count)
                    <span class="flex-space-1 overflow-hidden">
                        @icon('bi-book')
                        <span
                            class="truncate overflow-hidden whitespace-nowrap">{{ number_format($category->books_count) }}</span>
                    </span>
                @endif
            </div>
            <button type="button" x-on:click="toggleFavorite"
                class="text-lg flex-space-1">
                <i class="icon"
                    :class="{ 'bi-heart-fill text-red': favorite, 'bi-heart': !favorite }"></i>
            </button>
        </div>
    </div>
    <x-share-buttons :post="$category" />
</div>
