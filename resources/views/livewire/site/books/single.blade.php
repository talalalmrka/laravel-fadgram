<div class="post-entry py-6 -translate-y-30 mobile:-translate-y-18">
    <div class="relative z-1 w-40 aspect-[3/4] mx-auto shadow rounded-3xl overflow-hidden">
        <img src="{{ $book->getThumbnailUrl('lg') }}" class="w-full h-full object-cover" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="col">
            @include('livewire.site.books.book-details')
        </div>
        <div class="col-span-2">
            <p>{!! $book->content !!}</p>
            @if ($book->file)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="col">
                        <button type="button" wire:click="downloadFile" class="btn btn-blue w-full">
                            <i class="icon bi-cloud-download"></i>
                            <span wire:loading.remove wire:target="downloadFile">{{ __('Download') }}</span>
                            <fgx:loader wire:loading wire:target="downloadFile" />
                        </button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-green w-full">
                            <i class="icon bi-book"></i>
                            <span>{{ __('Read') }}</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-single-tags :model="$book" class="mt-6" />
    <x-single-share :model="$book" class="mt-6" />
    <x-next-prev :model="$book" />
    <livewire:site.books.book-quotes :$book wire:key="book-{{ $book->id }}-quotes" class="mt-6" />
    @if ($related && $related->isNotEmpty())
        <x-books-grid :title="$relatedLabel" title-class="mt-6" :books="$related" />
    @endif
    <livewire:site.comments.index :model="$book" :title="__('Reviews')" title-icon="bi-star-fill color-orange"
        wire:key="book_comments" class="mt-6" />
    <livewire:components.download-quote-dialog />
    @if (can('manage_books') && $book->edit_url)
        <x-slot name="footer">
            <a class="fixed bottom-5 start-5 btn btn-primary pill" target="_blank" href="{{ $book->edit_url }}">
                @icon('bi-pencil-square')
            </a>
        </x-slot>
    @endcan
</div>
