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
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach ($authors as $author)
                <x-authors-grid-item :author="$author" />
            @endforeach
        </div>
        @if (method_exists($authors, 'links'))
            <div class="mt-3">{{ $authors->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No authors found')" soft />
    @endif
</div>
