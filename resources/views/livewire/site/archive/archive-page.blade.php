<div class="containerr">
    @include('livewire.site.archive.archive-filters')
    <div class="relative">
        @if ($items->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                @foreach ($items as $item)
                    <div class="col">
                        <div
                            class="card relative shadow-none overflow-hidden hover:shadow transition-shadow duration-300">
                            <div
                                class="relative aspect-video bg-gray-200 flex items-center justify-center overflow-hidden">
                                <a href="{{ $item->permalink }}" title="{{ $item->name }}"
                                    class="leading-none w-full h-full overflow-hidden">
                                    <img class="w-full h-full object-cover" src="{{ $item->getThumbnailUrl('sm-webp') }}"
                                        alt="{{ $item->name }}">
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center truncate text-sm">
                                    <a class="text-inherit" href="{{ $item->permalink }}"
                                        title="{{ $item->name }}">{{ $item->name }}</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {!! $items->links() !!}
            </div>
        @else
            <div class="alert alert-info text-center mt-4">{{ __('No items') }}</div>
        @endif
    </div>
</div>
