<x-edit-dialog :model="$comment" :title="$title">
    <div class="grid grid-cols-1 gap-4">
        <div class="col">
            <fgx:label :label="__('Commented by')" />
            <div class="flex-space-2">
                <img src="{{ $comment->user?->getThumbnailUrl('xs') }}" alt="{{ $comment->user_name }}"
                    class="w-6 h-6 rounded-full">
                <a href="{{ $comment->user_permalink }}" target="_blank" title="{{ $comment->user_name }}"
                    class="link hover:link-underline">
                    {{ $comment->user_name }}
                </a>
            </div>
        </div>
        <div class="col">
            <fgx:label :label="__('Commented to')" />
            <div class="flex-space-2">
                <img src="{{ $comment->commentable_thumbnail_url }}" alt="{{ $comment->commentable_name }}"
                    class="w-6 h-6 rounded-full">
                <a href="{{ $comment->commentable_permalink }}" target="_blank" title="{{ $comment->commentable_name }}"
                    class="link hover:link-underline">
                    {{ $comment->commentable_name }}
                </a>
            </div>
        </div>
        <div class="col">
            <fgx:switch id="approved" wire:model.live="approved" :label="__('Approved')"
                :checked="$approved" />
        </div>
        <div class="col">
            <x-rating-input id="rating" model="rating" :rating="$rating" :label="__('Rating')" />
        </div>
        <div class="col">
            <fgx:textarea id="content" wire:model.live="content" :label="__('Content')" />
        </div>
    </div>
</x-edit-dialog>
