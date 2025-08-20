<div class="post-entry py-6">
    <x-breadcrumbs class="mb-4" />
    @if ($post->template === 'default')
        <h1 class="text-center text-2xl md:text-3xl lg:text-4xl">{{ $post->name }}</h1>
        <hr class="w-20 border-2 border-primary rounded mx-auto mb-6" />
    @endif
    @if ($post->getThumbnail())
        <figure class="post-featured-image rounded-lg overflow-hidden relative mb-4">
            <img src="{{ $post->getThumbnailUrl('lg') }}" alt="{{ $post->name }}"
                class="w-full object-cover {{ css_classes([]) }}">
        </figure>
    @endif
    @if ($post->template === 'curve')
        <x-slot name="curve">
            <x-single-meta :model="$post" class="text-white justify-center" />
        </x-slot>
    @else
        <x-single-meta :model="$post" />
    @endif

    {!! $post->content !!}
    <x-single-tags :model="$post" class="mt-6" />
    <x-single-share :model="$post" class="mt-6" />

    <x-next-prev :model="$post" class="mt-6" />

    <livewire:site.comments.index :model="$post" :title="__('Comments')" :rating="false"
        wire:key="post_comments_{{ $post->id }}" class="mt-6" />

    @if ($related && $related->isNotEmpty())
        <x-posts-grid :title="colored_title($relatedLabel)" :posts="$related" />
    @endif
    @if (can('manage_' . plural($post->type)) && $post->edit_url)
        <a class="fixed bottom-5 start-5 btn btn-primary pill" target="_blank" href="{{ $post->edit_url }}">
            @icon('bi-pencil-square')
        </a>
    @endcan
</div>
