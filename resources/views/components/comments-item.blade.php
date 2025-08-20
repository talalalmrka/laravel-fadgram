@props(['comment', 'class' => null, 'atts' => []])

<li {!! $attributes->merge(
    array_merge(
        [
            'id' => "comment-{$comment->id}",
            'wire:key' => $comment->id,
            'class' => css_classes(['flex space-x-2 py-2 animate-highlight', $class => $class]),
            'opacity-70' => $comment->hasPending(),
        ],
        $atts,
    ),
) !!}>
    <div>
        <div class="relative w-8 h-8 overflow-hidden rounded-full">
            <img class="w-full h-full object-cover"
                src="{{ $comment->user_thumbnail_url }}">
        </div>
    </div>

    <div class="grow">
        <div class="flex-space-2 justify-between">
            <div class="flex-1">
                <span
                    class="font-semibold">{{ $comment->author_name }}</span>
                @if ($comment->hasPending())
                    <span
                        class="badge sm badge-orange soft pill">{{ __('Pending Approval') }}</span>
                @endif
            </div>
            <div class="flex-space-2">
                <span class="text-xs flex-space-1">
                    @icon('bi-clock')
                    <span>{{ $comment->date_ago }}</span>
                </span>
                @if ($comment->hasActions())
                    <div x-cloak x-data="{ open: false }" x-on:click.away="open = false"
                        class="relative">
                        <button type="button" x-on:click="open = !open" class="nav-link">
                            <i class="icon bi-three-dots-vertical"></i>
                        </button>
                        <div x-show="open"
                            class="absolute w-40 end-0 shadow bg-white dark:bg-gray-700 border rounded-lg overflow-hidden divide-y divide-gray-200 dark:divide-gray-600">
                            @if ($comment->hasActionDelete())
                                <button type="button"
                                    wire:click="deleteComment({{ $comment->id }})"
                                    class="dropdown-link text-red">
                                    @icon('bi-trash-fill')
                                    <span>{{ __('Delete') }}</span>
                                    <fgx:loader wire:loading
                                        wire:target="deleteComment({{ $comment->id }})" />
                                </button>
                            @endif
                            @can('manage_comments')
                                <button type="button"
                                    wire:click="toggleApprove({{ $comment->id }})"
                                    class="dropdown-link {{ $comment->approved ? 'text-warning' : 'text-success' }}">
                                    <i class="icon {{ $comment->approved ? 'bi-clock-history' : 'bi-check2-circle' }}"></i>
                                    <span wire:loading.remove
                                        wire:target="toggleApprove({{ $comment->id }})">
                                        {{ $comment->approved ? __('UnApprove') : __('Approve') }}
                                    </span>
                                    <fgx:loader wire:loading
                                        wire:target="toggleApprove({{ $comment->id }})" />
                                </button>
                            @endcan
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if ($comment->rating)
            <x-rating :rating="$comment->rating ?? 0" class="mb-2" />
        @endif
        <p>{{ $comment->content ?? '' }}</p>
    </div>
</li>
