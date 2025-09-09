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
        <!-- horizontal scroll wrapper -->
        <div class="overflow-x-auto" tabindex="0" aria-label="Posts carousel">
            <!-- one-line responsive horizontal grid -->
            <div
                class="grid grid-flow-col gap-6
                       auto-cols-[calc(100%/1)]
                       md:auto-cols-[calc(100%/2)]
                       lg:auto-cols-[calc(100%/3)]
                       xl:auto-cols-[calc(100%/4)]
                       2xl:auto-cols-[calc(100%/5)]
                       snap-x snap-mandatory">
                @foreach ($posts as $post)
                    <div class="snap-start">
                        <x-posts-grid-item :post="$post" />
                    </div>
                @endforeach
            </div>
        </div>

        @if (method_exists($posts, 'links'))
            <div class="mt-3">{{ $posts->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No posts found')" soft />
    @endif
</div>
