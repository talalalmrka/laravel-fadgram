@props([
    'title' => null,
    'class' => null,
    'atts' => [],
    'categories' => null,
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

    @if ($categories && $categories->isNotEmpty())
        <!-- horizontal scroll wrapper -->
        <div class="overflow-x-auto py-4 px-4" tabindex="0" aria-label="Categories carousel">
            <!-- one-line responsive horizontal grid -->
            <div
                class="grid grid-flow-col gap-6
                       auto-cols-[calc(100%/1)]
                       md:auto-cols-[calc(100%/2)]
                       lg:auto-cols-[calc(100%/3)]
                       xl:auto-cols-[calc(100%/4)]
                       snap-x snap-mandatory">
                @foreach ($categories as $category)
                    <div class="snap-start">
                        <x-categories-grid-item :category="$category" />
                    </div>
                @endforeach
            </div>
        </div>

        @if (method_exists($categories, 'links'))
            <div class="mt-3">{{ $categories->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No categories found')" soft />
    @endif
</div>
