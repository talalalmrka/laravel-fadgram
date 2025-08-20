<section class="mt-6">
    <x-heading class="text-center text-lg md:text-xl lg:text-2xl mt-6 flex-space-2 justify-center">
        @icon('bi-chat')
        <span>{{ __('Reviews') }}</span>
    </x-heading>
    <form wire:submit="sendComment">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:textarea id="comment" wire:model.live="comment" :label="__('Comment')"
                    :placeholder="__('Insert the comment')" />
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    <i class="icon bi-send"></i>
                    <span wire:loading.remove wire:target="sendComment">{{ __('Post comment') }}</span>
                    <fgx:loader wire:loading wire:target="sendComment" />
                </button>
                <fgx:status class="alert-soft xs mt-2" />
            </div>
        </div>
    </form>
    <!-- Filters -->
    {{-- <div class="flex items-center justify-between text-sm mb-2 mt-6">
        <div class="relative w-40 flex items-center">
            <span class="absolute flex items-center top-0 bottom-0 start-0 px-2">
                @icon('bi-search', 'w-3')
            </span>
            <input type="search" class="form-control sm has-start-icon" placeholder="{{ __('Search') }}"
                wire:model.live="filters.search" />
        </div>
    </div> --}}<!-- End Filters -->
    <!-- List -->
    @if ($comments->isNotEmpty())
        <ul class="divide-y text-sm m-0 p-0 mt-6">
            @foreach ($comments as $comment)
                <li class="flex space-x-2 py-2">
                    <div class="relative w-10 h-10 overflow-hidden rounded-full">
                        <img class="w-full h-full object-cover"
                            src="{{ $comment->user->getAvatarUrl('xs') }}">
                    </div>
                    <div class="grow">
                        <div class="flex-space-2 justify-between">
                            <div class="font-semibold">{{ $comment->user->display_name }}</div>
                            <span class="text-xs">{{ $comment->date_ago }}</span>
                        </div>
                        <p class="card-text">{{ $comment->content }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="mt-3">
            {{ $comments->links() }}
        </div>
    @else
        <fgx:alert :content="__('No comments')" soft />
    @endif
    <!-- End List -->
</section>
