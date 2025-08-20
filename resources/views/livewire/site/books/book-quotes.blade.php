<div id="book-quotes-section-{{ $book->id }}" class="book-quotes-section {{ $class }}">
    @if ($title)
        <x-heading-strip :title="$title" icon="bi-quote text-primary">
            @if ($addQuoteEnabled)
                <x-slot name="actions">
                    <button wire:click="addQuote" type="button" class="btn btn-primary btn-xs">
                        <i class="icon fg-plus"></i>
                        <span wire:loading.remove wire:target="addQuote">{{ __('Add quote') }}</span>
                        <fgx:loader wire:loading wire:target="addQuote" />
                    </button>
                </x-slot>
            @endif
        </x-heading-strip>
    @endif
    @if ($addQuoteEnabled)
        <x-modal :title="__('Add quote')" show="showQuoteModal">
            <form wire:submit="sendQuote">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:textarea id="newQuote" wire:model.live="newQuote" :label="__('Quote')"
                            :placeholder="__('Write quote...')" />
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon bi-send"></i>
                            <span wire:loading.remove wire:target="sendQuote">{{ __('Add quote') }}</span>
                            <fgx:loader wire:loading wire:target="sendQuote" />
                        </button>
                        <fgx:status class="alert-soft xs mt-2" />
                    </div>
                </div>
            </form>
        </x-modal>
    @endif
    <!-- Filters -->
    <div class="flex items-center justify-between text-sm mt-6 mb-3">
        <div class="max-w-40">
            <fgx:input type="search" id="search" wire:model.live="search" :placeholder="__('search')"
                class="xs pill" startIcon="bi-search" />
        </div>

        <div class="">
            <fgx:select id="sort" wire:model.live="sort" :options="sort_options()"
                class="xs pill w-40" />
        </div>
    </div><!-- End Filters -->
    @if ($quotes->isNotEmpty())
        <div class="flex flex-col gap-4">
            @foreach ($quotes as $quote)
                <x-quotes-item :quote="$quote" />
            @endforeach
        </div>
        <div class="mt-3 text-center">
            @if ($hasMore)
                <button wire:click="loadMore" wire:loading.attr="disabled" wire:target="loadMore"
                    class="btn btn-xs btn-outline-primary mx-auto">
                    <span wire:loading.remove wire:target="loadMore">
                        {{ __('Load More') }}
                    </span>
                    <fgx:loader wire:loading wire:target="loadMore" />
                    <i class="icon bi-chevron-right rtl:bi-chevron-left"></i>
                </button>
            @endif
        </div>
    @else
        <fgx:alert :content="__('No quotes found.')" soft />
    @endif
</div>
