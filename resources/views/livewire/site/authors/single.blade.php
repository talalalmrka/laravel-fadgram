<div class="py-6 -translate-y-14">
    <x-slot name="curve">
        <x-breadcrumbs class="justify-center" />
    </x-slot>
    <div class="relative z-1 w-16 h-16 mx-auto shadow rounded-full overflow-hidden">
        <img src="{{ $author->getThumbnailUrl('sm') }}" class="w-full h-full object-cover" />
    </div>
    @if (!empty($author->content))
        <p>{!! $author->content !!}</p>
    @endif
    <div x-tabs class="mt-6">
        <div x-tabs-header>
            @if ($quotes)
                <button x-tab="quotes" class="flex-space-1">
                    @icon('bi-quote')
                    <span>{{ __('Quotes') }}</span>
                </button>
            @endif
            @if ($books)
                <button x-tab="books" class="flex-space-1">
                    @icon('bi-book')
                    <span>{{ __('Books') }}</span>
                </button>
            @endif
        </div>
        <div x-tabs-content>
            @if ($quotes)
                <div x-tab-panel="quotes">
                    <x-quotes-grid :quotes="$quotes" />
                </div>
            @endif
            @if ($books)
                <div x-tab-panel="books">
                    <x-books-grid :books="$books" />
                </div>
            @endif
        </div>
    </div>

</div>
