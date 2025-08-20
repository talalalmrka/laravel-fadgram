@props([
    'title' => null,
    'class' => null,
    'atts' => [],
    'posts' => null,
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
    @if ($posts && $posts->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <x-posts-grid-item :post="$post" />
            @endforeach
        </div>
        @if (method_exists($posts, 'links'))
            <div class="mt-3">{{ $posts->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No posts found')" soft />
    @endif
</div>
