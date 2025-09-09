@props([
    'title' => null,
    'class' => null,
    'atts' => [],
    'authors' => null,
])
<div
    {{ $attributes->merge(
        array_merge(
            [
                'class' => css_classes([$class => $class]),
            ],
            $atts,
        ),
    ) }}>
    @if ($title)
        <x-heading-strip :title="$title" />
    @endif
    @if ($authors && $authors->isNotEmpty())
        <!-- horizontal scroll wrapper -->
        <div class="overflow-x-auto py-4" tabindex="0" aria-label="Authors carousel">
            <!-- one-line responsive horizontal grid -->
            <div
                class="grid grid-flow-col gap-6
                   auto-cols-[calc(100%/1)]
                   md:auto-cols-[calc(100%/3)]
                   lg:auto-cols-[calc(100%/4)]
                   xl:auto-cols-[calc(100%/5)]
                   snap-x snap-mandatory">
                @foreach ($authors as $author)
                    <div class="snap-start">
                        <x-authors-grid-item :author="$author" />
                    </div>
                @endforeach
            </div>
        </div>

        @if (method_exists($authors, 'links'))
            <div class="mt-3">{{ $authors->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No authors found')" soft />
    @endif
</div>
