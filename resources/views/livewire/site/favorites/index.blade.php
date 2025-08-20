<div class="py-6">
    <x-slot name="curve">
        <x-breadcrumbs class="justify-center" container-class="mb-4" />
    </x-slot>
    {{ $this->filtersView(['category_options' => null]) }}
    @if ($favorites && $favorites->isNotEmpty())
        <div class="masonry-columns columns-1 md:columns-3 lg:columns-4 gap-6">
            @foreach ($favorites as $favorite)
                <x-favorites-grid-item :favorite="$favorite" class="mb-6" />
            @endforeach
        </div>
        @if (method_exists($favorites, 'links'))
            <div class="mt-3">{{ $favorites->links() }}</div>
        @endif
    @else
        <fgx:alert :content="__('No favorites found')" soft />
    @endif
    <livewire:components.download-quote-dialog />
</div>
