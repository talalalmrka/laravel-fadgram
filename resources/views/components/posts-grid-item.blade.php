@props(['post', 'share_enabled' => get_option('share_enabled'), 'class' => null, 'atts' => []])
<div x-data="{
    postId: @js($post->id),
    share: false,
    favorite: @js($post->isFavorited()),
    toggleFavorite() {
        this.favorite = !this.favorite;
        $wire.toggleFavorite(this.postId)
    }
}"
    {{ $attributes->merge(
        array_merge(
            [
                'wire:key' => $post->id,
                'id' => "post-{$post->id}",
                'class' => css_classes([
                    'card relative rounded-3xl shadow-sm hover:shadow hover:scale-[1.03] transition-all duration-300',
                    "post-{$post->id}",
                    $class => $class,
                ]),
            ],
            $atts,
        ),
    ) }}>
    <div class="relative aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
        <a href="{{ $post->permalink }}" title="{{ $post->name }}"
            class="relative leading-none w-full h-full overflow-hidden group">
            <img class="w-full h-full object-cover group-hover:scale-110 transition-all duration-300"
                src="{{ $post->getThumbnailUrl('sm') }}"
                alt="{{ $post->name }}">
            <div
                class="absolute z-1 inset-0 bg-gradient-to-r from-black/30 via-black/10 to-black/30 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                <i
                    class="icon bi-link-45deg text-white w-10 h-10 scale-50 group-hover:scale-100 transition-transform"></i>
            </div>
        </a>
        @if ($post->category())
            <a href="{{ $post->category_permalink }}" title="{{ $post->category_name }}"
                class="badge pill badge-primary absolute top-2 start-2">
                {{ $post->category_name }}
            </a>
        @endif
    </div>
    <div class="card-body flex flex-col">
        <h2 class="text-lg mb-2 font-semibold">
            <a class="hover:link-underline" href="{{ $post->permalink }}"
                title="{{ $post->name }}">
                {{ $post->name }}
            </a>
        </h2>
        @if (get_option('excerpt_enabled'))
            <p class="mb-0 text-base text-muted flex-1">
                {{ $post->excerpt }}
            </p>
        @endif
        <div
            class="flex-space-2 justify-between border-t text-xs text-muted pt-2 mt-2 truncate flex-nowrap overflow-hidden">
            <div class="flex-space-2 flex-1 truncate flex-nowrap overflow-hidden">
                @if ($post->author)
                    <a href="{{ $post->author_permalink }}" title="{{ $post->author_name }}"
                        class="flex-space-1 overflow-hidden hover:link-underline">
                        @icon('bi-person')
                        <span class="truncate overflow-hidden whitespace-nowrap">{{ $post->author_name }}</span>
                    </a>
                @endif
                <span class="flex-space-1 overflow-hidden">
                    @icon('bi-clock')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $post->date_ago }}</span>
                </span>
                <span class="flex-space-1 overflow-hidden">
                    @icon('bi-eye')
                    <span class="truncate overflow-hidden whitespace-nowrap">{{ $post->views_formatted }}</span>
                </span>
            </div>
            <button type="button" x-on:click="toggleFavorite"
                class="text-lg flex-space-1">
                <i class="icon"
                    :class="{ 'bi-heart-fill text-red': favorite, 'bi-heart': !favorite }"></i>
            </button>
        </div>
    </div>
    <x-share-buttons :post="$post" />
</div>
