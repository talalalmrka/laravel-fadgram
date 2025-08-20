@props(['quote', 'class' => null, 'atts' => []])

<div {!! $attributes->merge(
    array_merge(
        [
            'id' => "comment-{$quote->id}",
            'wire:key' => $quote->id,
            'class' => css_classes([
                'bg-white dark:bg-gray-700 border rounded-lg shadow-xs hover:shadow animate-highlight',
                $class => $class,
            ]),
        ],
        $atts,
    ),
) !!}>
    <div class="border-b flex-space-2 p-1 text-xs">
        <a class="flex-space-2 hover:link-underline" href="{{ $quote->author_permalink }}">
            <img class="w-6 h-6 rounded-full object-cover"
                src="{{ $quote->author_thumbnail }}">
            <span>{{ $quote->author_name }}</span>
        </a>
        <div class="flex-1 flex-space-2 justify-end">
            @if ($quote->status !== 'publish')
                <span class="badge badge-warning badge-outline sm">
                    @icon('bi-clock-history')
                    <span>{{ __('Pending') }}</span>
                </span>
            @endif
            <button wire:click="downloadQuote({{ $quote->id }})" type="button" class="hover:link">
                <i wire:loading.remove wire:target="downloadQuote({{ $quote->id }})"
                    class="icon bi-cloud-download"></i>
                <i class="icon fg-loader-dots-move" wire:loading wire:target="downloadQuote({{ $quote->id }})"></i>
            </button>
            <a href="{{ $quote->permalink }}" title="{{ $quote->name }}" class="hover:link-underline">
                <i class="icon bi-box-arrow-up-right"></i>
            </a>

            @if (can('manage_quotes'))
                <button type="button" wire:click="toggleStatus({{ $quote->id }})"
                    class="{{ css_classes(['flex-space-1', 'text-green' => $quote->status !== 'publish', 'text-orange' => $quote->status === 'publish']) }}">
                    <i class="icon {{ $quote->status === 'publish' ? 'bi-clock-history' : 'bi-check2-circle' }}"></i>
                    <span wire:loading.remove
                        wire:target="toggleStatus({{ $quote->id }})">{{ $quote->status === 'publish' ? __('Unapprove') : __('Approve') }}</span>
                    <fgx:loader wire:loading wire:target="toggleStatus({{ $quote->id }})" />
                </button>
            @endif
            @if (can('manage_quotes') || (auth()->check() && is_user($quote->author) && $quote->author_id === current_user_id()))
                <button type="button" wire:click="delete({{ $quote->id }})" class="text-red flex-space-1">
                    <i class="icon bi-trash"></i>
                    <span wire:loading.remove wire:target="delete({{ $quote->id }})"
                        class="mobile:hidden">{{ __('Delete') }}</span>
                    <fgx:loader wire:loading wire:target="delete({{ $quote->id }})" />
                </button>
            @endif
            <span class="text-xs flex-space-1">
                @icon('bi-clock')
                <span>{{ $quote->date_ago }}</span>
            </span>
        </div>

    </div>
    <p class="text-center text-2xl">
        <i class="icon bi-quote text-primary"></i>
        {{ $quote->content }}
        <i class="icon bi-quote rotate-180 text-primary"></i>
    </p>
</div>
