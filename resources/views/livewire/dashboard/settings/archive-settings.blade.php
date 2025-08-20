<x-settings-page>
    <x-settings-card :title="__('Excerpt settings')">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col">
                <fgx:label for="excerpt_enabled" :label="__('Enable')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:switch id="excerpt_enabled" wire:model.live="excerpt_enabled" />
            </div>
            <div class="col">
                <fgx:label for="excerpt_length" :label="__('Excerpt length')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" min="0" max="500" id="excerpt_length"
                    wire:model.live="excerpt_length" />
            </div>
            <div class="col">
                <fgx:label for="excerpt_more" :label="__('Excerpt more')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="excerpt_more" wire:model.live="excerpt_more" />
            </div>
            <div class="col">
                <fgx:label for="excerpt_preverse_words" :label="__('Preverse words')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:switch id="excerpt_preverse_words" wire:model.live="excerpt_preverse_words" />
            </div>
        </div>
    </x-settings-card>
    <x-settings-card :title="__('Share settings')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col">
                <fgx:label for="share_enabled" :label="__('Enable')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:switch id="share_enabled" wire:model.live="share_enabled" />
            </div>
            <div class="col">
                <fgx:label for="share_label" :label="__('Share label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="share_label" wire:model.live="share_label" />
                {{ get_option_type('share_label') }}
            </div>
            <div class="col col-span-4">
                <h5>{{ __('Share buttons') }}</h5>
                @foreach ($share_buttons as $i => $button)
                    <div class="border rounded-lg p-2 mb-4 animate-fadein">
                        <div class="flex flex-col items-center lg:flex-row gap-4">
                            <div>
                                <fgx:switch id="share_buttons.{{ $i }}.enabled"
                                    wire:model.live="share_buttons.{{ $i }}.enabled"
                                    :label="__('Enabled')" />
                            </div>
                            <div>
                                <x-icon-picker id="share_buttons.{{ $i }}.icon" dropdown_class="z-20"
                                    wire:model.live="share_buttons.{{ $i }}.icon" :label="__('Icon')"
                                    :value="data_get($button, 'icon')" />
                            </div>
                            <div>
                                <fgx:input id="share_buttons.{{ $i }}.name"
                                    wire:model.live="share_buttons.{{ $i }}.name" :label="__('Label')" />
                            </div>
                            <div class="flex-1">
                                <fgx:input id="share_buttons.{{ $i }}.url"
                                    wire:model.live="share_buttons.{{ $i }}.url" :label="__('Url')" />
                            </div>
                            <div>
                                <button type="button" wire:click="deleteShareButton({{ $i }})"
                                    class="btn btn-xs btn-outline-red">
                                    <i class="icon bi-trash"></i>
                                    <span wire:loading.remove
                                        wire:target="deleteShareButton({{ $i }})">{{ __('Remove') }}</span>
                                    <fgx:loader wire:loading wire:target="deleteShareButton({{ $i }})" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="text-center">
                    <button type="button" wire:click="addShareButton" class="btn btn-sm btn-outline-primary">
                        <i class="icon fg-plus"></i>
                        <span wire:loading.remove wire:target="addShareButton">{{ __('Add button') }}</span>
                        <fgx:loader wire:loading wire:target="addShareButton" />
                    </button>
                </div>
            </div>
        </div>
    </x-settings-card>
</x-settings-page>
