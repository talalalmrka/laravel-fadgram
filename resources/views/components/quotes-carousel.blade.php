@props([
    'title' => null,
    'class' => null,
    'atts' => [],
    'quotes' => null,
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
    @if ($quotes && $quotes->isNotEmpty())
        <div class="overflow-x-auto py-4">
            <div
                class="grid grid-flow-col auto-cols-[calc(100%/1)]
           lg:auto-cols-[calc(100%/3)]
           xl:auto-cols-[calc(100%/4)]
           2xl:auto-cols-[calc(100%/5)]
           snap-x snap-mandatory gap-4">
                @foreach ($quotes as $quote)
                    <x-quotes-grid-item :quote="$quote" />
                @endforeach
            </div>
        </div>
        @if (method_exists($quotes, 'links'))
            <div class="mt-3">{{ $quotes->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No quotes found')" soft />
    @endif
</div>
