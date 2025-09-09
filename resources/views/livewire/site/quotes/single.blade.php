<div
    class="post-entry py-6 -translate-y-30 mobile:-translate-y-18">
    <x-slot name="curve">
        <x-breadcrumbs class="mb-4" class="justify-center" />
        <x-single-meta :model="$quote" class="text-white justify-center" />
    </x-slot>
    {{-- @include('livewire.components.download-quote') --}}
    {{-- <livewire:components.download-quote :quote="$quote" key="download-quote-{{ $quote->id }}" /> --}}
    <x-quote-images-picker :quote="$quote" />

    <p class="text-center mt-6 text-xl md:text-2xl lg:text-3xl">
        @icon('bi-quote text-primary')
        {!! $quote->content !!}
        @icon('bi-quote text-primary rotate-180')
    </p>
    @if ($quote->book)
        <div class="text-center">
            {{ __('From book:') }} <a href="{{ $quote->book->permalink }}" class="link hover:link-underline"
                title="{{ $quote->book->name }}">{{ $quote->book->name }}</a>
        </div>
    @endif
    <x-single-tags :model="$quote" class="mt-6" />
    <x-single-share :model="$quote" class="mt-6" />
    @if ($related && $related->isNotEmpty())
        <x-quotes-grid :title="colored_title($relatedLabel)" :quotes="$related" class="mt-6" />
    @endif
    <x-next-prev :model="$quote" class="mt-6" />

    <livewire:site.comments.index :model="$quote" :title="__('Comments')" :rating="false"
        wire:key="quote_comments_{{ $quote->id }}" class="mt-6" />
    @if (can('manage_quotes') && $quote->edit_url)
        <x-slot name="footer">
            <a class="fixed bottom-5 start-5 btn btn-primary pill" target="_blank" href="{{ $quote->edit_url }}">
                @icon('bi-pencil-square')
            </a>
        </x-slot>
    @endcan
    {{-- <livewire:components.download-quote-dialog /> --}}
</div>
