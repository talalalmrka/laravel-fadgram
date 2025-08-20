<div class="container py-6">
    @include('livewire.site.archive.archive-filters', [
        'sort_options' => $sort_options,
        'category_options' => $category_options,
    ])
    @if ($posts && $posts->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($posts as $post)
                <x-quotes-grid-item :post="$post" />
            @endforeach
        </div>
        <div class="mt-3">{{ $posts->links() }}</div>
    @else
        <fgx:alert :content="__('No posts found')" soft />
    @endif

</div>
