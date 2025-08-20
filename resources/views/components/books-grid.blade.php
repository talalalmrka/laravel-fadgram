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
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach ($books as $book)
            <x-books-grid-item :book="$book" />
        @endforeach
    </div>
    @if (method_exists($books, 'links'))
        <div class="mt-3">{{ $books->links() }}</div>
    @endif
@else
    <fgx:alert :content="__('No books found')" soft />
@endif
