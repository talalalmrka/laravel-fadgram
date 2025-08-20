@props([
    'authors' => null,
])
@if ($authors && $authors->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
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
