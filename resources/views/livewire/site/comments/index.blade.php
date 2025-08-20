<div {!! attributes($atts)->merge([
    'id' => 'comments',
    'class' => css_classes(["post-comments post-comments-{$model->id}", $class => $class]),
]) !!}>
    @if ($title)
        <x-heading-strip :title="$title" :icon="$titleIcon" :class="$headingClass" :atts="$headingAtts" :title-class="$titleClass"
            :title-atts="$titleAtts" :tag="$titleTag" :color="$headingStripColor" />
    @endif
    <div class="grid grid-cols-1 gap-6 {{ css_classes(['md:grid-cols-4' => $rating]) }}">
        @if ($rating)
            <div class="col">
                <div class="flex-space-2">
                    <h2 class="mb-0">{{ $model->rating }}</h2>
                    <div>
                        <x-rating :rating="$model->rating" />
                        <div class="text-sm">{{ __('From :count reviews', ['count' => $count]) }}</div>
                    </div>
                </div>
                <div>
                    @foreach ($model->review_progress as $rating => $percent)
                        <div class="flex-space-2">
                            <span class="flex-space-1">
                                <span>{{ $rating }}</span>
                                @icon('bi-star-fill text-orange')
                            </span>
                            <div class="grow">
                                <div class="progress" role="progressbar">
                                    <div class="progress-bar" style="width: {{ $percent }}%;"></div>
                                </div>
                            </div>
                            <span>{{ __(':percent%', ['percent' => $percent]) }}</span>
                        </div>
                    @endforeach
                </div>
            </div><!--End Progress -->
        @endif
        <!-- Comments -->
        <div class="col {{ css_classes(['md:col-span-3' => $rating]) }}">
            <form wire:submit="sendComment">
                <div class="grid grid-cols-1 gap-3">
                    @if ($rating)
                        <div class="col">
                            <fgx:label id="newRating" :label="__('Rating')" />
                            <div class="flex-space-1 rating-bar">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" class=""
                                        wire:click="$set('newRating', {{ $i }})">
                                        <i class="icon bi-star-fill {{ $i <= $newRating ? 'active' : '' }}"></i>
                                    </button>
                                @endfor
                            </div>
                            <fgx:error id="newRating" />
                        </div>
                    @endif

                    <div class="col">
                        <fgx:textarea id="newComment" wire:model.live="newComment" rows="3" :label="__('Comment')"
                            :placeholder="__('Insert the comment')" />
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon bi-send"></i>
                            <span wire:loading.remove wire:target="sendComment">{{ __('Send') }}</span>
                            <fgx:loader wire:loading wire:target="sendComment" />
                        </button>
                        <fgx:status id="send_comment" class="alert-soft xs mt-2" />
                    </div>
                </div>
            </form>
            <!-- Filters -->
            <div class="flex items-center justify-between text-sm mt-4 mb-3">
                <div class="max-w-40">
                    <fgx:input type="search" id="search" wire:model.live="search" :placeholder="__('search')"
                        class="xs pill" startIcon="bi-search" />
                </div>

                <div class="">
                    <fgx:select id="sort" wire:model.live="sort" :options="comments_sort_options()"
                        class="xs pill w-40" />
                </div>
            </div><!-- End Filters -->
            <!-- List -->

            @if ($comments->isNotEmpty())
                <ul class="divide-y text-sm m-0 p-0">
                    @foreach ($comments as $comment)
                        <x-comments-item :comment="$comment" />
                    @endforeach
                </ul>
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
                <fgx:alert :content="__('No items found.')" soft />
            @endif
        </div><!-- End Comments -->
    </div>
    </section>
