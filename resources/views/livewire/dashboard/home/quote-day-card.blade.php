<div wire:cloak x-data="{ add: false }" class="card overflow-visible">
    <div class="card-header">
        <h5 class="card-title text-primary flex-space-2">
            @icon('bi-quote')
            <span>{{ __('Quote of the day: :date', ['date' => $today_formatted]) }}</span>
        </h5>
    </div>
    <div class="card-body">

        @if ($quoteDays && $quoteDays->isNotEmpty())
            <div class="flex flex-col space-y-2">
                @foreach ($quoteDays as $quoteDay)
                    <div class="px-3 py-2 flex-space-2 border rounded-2xl">
                        <div class="flex-1">
                            <a class="hover:link-underline"
                                href="{{ $quoteDay->quote_permalink }}">
                                <p>
                                    {{ $quoteDay->quote_content }}
                                </p>
                            </a>

                            <a class="text-sm text-muted hover:link-underline flex-space-2"
                                href="{{ $quoteDay->category_permalink }}">
                                @icon('bi-folder')
                                <span>{{ $quoteDay->category_name }}</span>
                            </a>
                        </div>
                        <button wire:click="delete({{ $quoteDay->id }})" type="button"
                            class="link-red text-sm">
                            <i class="icon bi-trash"></i>
                            <fgx:loader wire:loading wire:target="delete({{ $quoteDay->id }})" />
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <fgx:alert :content="__('No quotes today!')" soft />
        @endif

        <button x-show="!add" x-on:click="add = true" type="button" class="btn btn-sm btn-outline-primary mt-3">
            <i class="icon bi-plus-lg"></i>
            <span>{{ __('Add') }}</span>
        </button>
        <form x-collapse x-show="add" wire:submit="save" class="mt-4">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <livewire:components.select-category key="category_id" wire:model.live="category_id"
                        label="Category" show-count="quotes_count" :has-quotes="true" :not-in="$notIn" />
                </div>
                <div class="col">
                    <livewire:components.select-quote key="quote_id-{{ $category_id ?? 'no' }}"
                        wire:model.live="quote_id"
                        label="Quote" category="{{ $category_id }}" />
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">
                        <i class="icon bi-floppy"></i>
                        <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                        <fgx:loader wire:loading wire:target="save" />
                    </button>
                    <fgx:status class="alert-soft xs mt-2" />
                </div>
            </div>
        </form>
    </div>
</div>
