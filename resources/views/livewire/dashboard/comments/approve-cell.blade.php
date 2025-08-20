@props(['comment'])
<div class="flex-space-2">
    <span wire:loading.remove wire:target="toggleApproved({{ $comment->id }})">
        <fgx:switch x-on:change="$wire.toggleApproved({{ $comment->id }})" :checked="$comment->approved" />
    </span>
    <x-loader wire:loading wire:target="toggleApproved({{ $comment->id }})" />
</div>
