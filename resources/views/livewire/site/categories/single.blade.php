<div class="py-6">
    <x-breadcrumbs class="mb-4" />
    <div x-tabs class="mt-6">
        <div x-tabs-header>
            @if ($posts)
                <button x-tab="posts" class="flex-space-1">
                    @icon('bi-newspaper')
                    <span>{{ __('Posts') }}</span>
                </button>
            @endif
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
            @if ($posts)
                <div x-tab-panel="posts">
                    <x-posts-grid :posts="$posts" />
                </div>
            @endif
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
