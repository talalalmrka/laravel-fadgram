<div class="text-sm divide-y">
    @if ($book->author)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-person text-primary')
                <span>{{ __('Author:') }}</span>
            </span>
            <div class="text-muted">
                <a href="{{ $book->author_permalink }}" title="{{ $book->author_name }}"
                    class="hover:link-underline flex-space-2 flex-wrap">
                    <img class="w-8 h-8 rounded-full object-cover" src="{{ $book->author_thumbnail }}" />
                    <span>{{ $book->author_name }}</span>
                </a>
            </div>
        </div>
    @endif
    @if ($book->categories)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-folder text-primary')
                <span>{{ __('Category:') }}</span>
            </span>
            <div class="text-muted">
                {!! $book->categoriesLinks(['class' => 'hover:link-underline badge badge-outline badge-blue pill']) !!}
            </div>
        </div>
    @endif
    @if ($book->year)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-calendar-event text-primary')
                <span>{{ __('Publish year:') }}</span>
            </span>
            <div class="text-muted">
                {{ $book->year }}
            </div>
        </div>
    @endif
    @if ($book->pages)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-calendar-event text-primary')
                <span>{{ __('Pages:') }}</span>
            </span>
            <div class="text-muted">
                {{ $book->pages }}
            </div>
        </div>
    @endif
    @if ($book->file_size)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-file-earmark-bar-graph text-primary')
                <span>{{ __('Size:') }}</span>
            </span>
            <div class="text-muted">
                {{ $book->file_size }}
            </div>
        </div>
    @endif
    @if ($book->file_type)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-file-earmark-medical text-primary')
                <span>{{ __('Type:') }}</span>
            </span>
            <div class="text-muted">
                {{ $book->file_type }}
            </div>
        </div>
    @endif
    @if ($book->downloads)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-cloud-download text-primary')
                <span>{{ __('Downloads:') }}</span>
            </span>
            <div class="text-muted">
                {{ $book->downloads_formatted }}
            </div>
        </div>
    @endif
    @if ($book->downloads)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-book text-primary')
                <span>{{ __('Reads:') }}</span>
            </span>
            <div class="text-muted">
                {{ $book->reads_formatted }}
            </div>
        </div>
    @endif
    @if ($book->views)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-eye text-primary')
                <span>{{ __('Views:') }}</span>
            </span>
            <div class="text-muted">
                {{ $book->views_formatted }}
            </div>
        </div>
    @endif
    @if ($book->rating)
        <div class="flex flex-space-2 py-1">
            <span class="flex-space-1 w-1/3">
                @icon('bi-star text-primary')
                <span>{{ __('Rating:') }}</span>
            </span>
            <div class="text-muted">
                <x-rating :rating="$book->rating" />
            </div>
        </div>
    @endif
</div>
