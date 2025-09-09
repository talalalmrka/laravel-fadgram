@props([
    'title' => null,
    'icon' => null,
    'color' => 'primary',
    'titleColored' => true,
    'titleClass' => 'mb-0',
    'headingClass' => null,
    'titleType' => 'strip',
    'books' => null,
])
@if ($title)
    @if ($titleType === 'center')
        <x-heading :title="$title" :colored="$titleColored" :class="$titleClass" />
    @else
        <x-heading-strip :title="$title" :icon="$icon" :color="$color" :class="$headingClass" :title-class="$titleClass" />
    @endif
@endif

@if ($books && $books->isNotEmpty())
    <!-- horizontal scroll wrapper -->
    <div class="overflow-x-auto py-4" tabindex="0" aria-label="Books carousel">
        <!-- one-line responsive horizontal grid -->
        <div
            class="grid grid-flow-col gap-6
                   auto-cols-[calc(100%/2)]
                   md:auto-cols-[calc(100%/3)]
                   lg:auto-cols-[calc(100%/4)]
                   xl:auto-cols-[calc(100%/5)]
                   snap-x snap-mandatory">
            @foreach ($books as $book)
                <div class="snap-start">
                    <x-books-grid-item :book="$book" />
                </div>
            @endforeach
        </div>
    </div>

    @if (method_exists($books, 'links'))
        <div class="mt-3">{{ $books->links() }}</div>
    @endif
@else
    <fgx:alert :content="__('No books found')" soft />
@endif
