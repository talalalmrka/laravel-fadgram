@props(['post', 'buttons' => share_buttons()])
@if ($buttons && $buttons->isNotEmpty())
    <div x-cloak x-transition x-show="share" class="absolute inset-0 bg-black/40 z-2 flex items-center justify-center">
        <div class="flex flex-wrap justify-center">
            @foreach ($buttons as $button)
                <a href="{{ $button->shareUrl($post) }}" title="{{ $button->name }}" target="_blank"
                    class="btn {{ $button->buttonClass() }}" style="border-radius: 0 !important;">
                    @icon($button->icon)
                </a>
            @endforeach
        </div>
    </div>
    <button x-cloak x-on:click="share = !share" type="button" title="{{ __('Share') }}"
        class="text-white bg-primary/80 hover:bg-primary w-7 h-7 flex items-center justify-center p-0 rounded-full absolute z-3 top-2 end-2">
        <i x-show="!share" class="icon bi-share-fill"></i>
        <i x-show="share" class="icon bi-x-lg"></i>
    </button>
@endif
