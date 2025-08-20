@props([
    'title' => null,
    'class' => null,
    'atts' => [],
    'quotes' => null,
])
<div {{ $attributes->merge(
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
    @if ($quotes && $quotes->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 xxl:grid-cols-5 gap-6">
            @foreach ($quotes as $quote)
                <x-quotes-grid-item :quote="$quote" />
            @endforeach
        </div>
        @if (method_exists($quotes, 'links'))
            <div class="mt-3">{{ $quotes->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No quotes found')" soft />
    @endif
</div>
