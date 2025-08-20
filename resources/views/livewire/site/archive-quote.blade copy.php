<div class="container py-6">
    @include('livewire.site.archive.archive-filters', [
        'sort_options' => $sort_options,
        'category_options' => $category_options,
    ])
    @if ($posts && $posts->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($posts as $post)
                <div wire:key="{{ $post->id }}"
                    class="bg-white dark:bg-zinc-900 border border-yellow-200 dark:border-yellow-800 rounded-3xl shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300 overflow-hidden flex flex-col justify-between p-5">
                    <div class="relative aspect-video bg-gray-100 dark:bg-gray-800 mb-4 rounded-xl overflow-hidden">
                        <a href="{{ $post->permalink }}" title="{{ $post->name }}" class="block w-full h-full">
                            <img src="{{ $post->getThumbnailUrl('sm') }}" alt="{{ $post->name }}"
                                class="w-full h-full object-cover" loading="lazy">
                        </a>
                    </div>

                    {{-- Quote Content --}}
                    <div class="text-center mb-4 px-1">
                        <a href="{{ $post->permalink }}"
                            class="text-gray-800 dark:text-gray-100 hover:text-yellow-600 dark:hover:text-yellow-400 transition">
                            <p class="text-lg md:text-xl font-serif italic leading-relaxed tracking-wide">
                                <i class="bi bi-quote text-yellow-500"></i>
                                {{ $post->excerpt }}
                                <i class="bi bi-quote text-yellow-500 rotate-180"></i>
                            </p>
                        </a>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 italic">
                            — {{ $post->author_name ?? 'Unknown' }}
                        </p>
                    </div>
                    <div class="flex-space-2 justify-between text-muted text-sm">
                        <a href="{{ $post->author_permalink }}" title="{{ $post->author_name }}" class="flex-space-1">
                            @icon('bi-person')
                            <span>{{ $post->author_name }}</span>
                        </a>
                        <button type="button" title="{{ __('Share') }}">
                            <i class="icon bi-share-fill"></i>
                        </button>
                    </div>
                    {{-- Meta Info --}}
                    <div
                        class="flex-space-2 justify-between border-t dark:border-gray-700 pt-2 text-sm text-gray-500 dark:text-gray-400">

                        <span class="flex-space-1">
                            @icon('bi-clock')
                            <span>{{ $post->date_ago }}</span>
                        </span>
                        <span class="flex-space-1">
                            @icon('bi-eye')
                            <span>{{ $post->views_formatted }}</span>
                        </span>
                        <button type="button" x-data="{ favorite: false }" x-on:click="favorite = !favorite"
                            class="text-sm flex-space-1">
                            <i class="icon"
                                :class="{ 'bi-heart-fill text-red': favorite, 'bi-heart': !favorite }"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">{{ $posts->links() }}</div>
    @else
        <fgx:alert :content="__('No posts found')" soft />
    @endif

</div>
