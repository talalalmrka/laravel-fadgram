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
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <x-categories-grid-item :category="$category" />
            @endforeach
        </div>
        @if (method_exists($categories, 'links'))
            <div class="mt-3">{{ $categories->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No categories found')" soft />
    @endif
</div>
