<x-dialog :title="$title">
    @if ($media->id)
        <div class="grid grid-cols-3 gap-4">
            <div class="col md:col-span-2 flex items-center justify-center">
                @include('livewire.dashboard.media.preview', [
                    'media' => $media,
                    'class' => 'w-auto h-auto max-w-full max-h-full border-0 bg-transparent',
                ])
            </div>
            <div class="col">
                @include('livewire.dashboard.media.details', ['media' => $media])
                <div x-data="{
                    copied: false,
                    url: '{{ $media->original_url }}'
                }" class="list-group-item">
                    <div class="font-semibold">{{ __('url:') }}</div>
                    <div class="flex">
                        <input type="text" value="{{ $media->original_url }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 focus:ring-transparent focus:border-primary block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 [&.error]:dark:placeholder-red-700 dark:text-white dark:focus:ring-transparent dark:focus:border-primary [&.error]:bg-red-50 [&.error]:border-red-500 [&.error]:text-red-900 [&.error]:placeholder-red-700 [&.error]:focus:border-red-700 p-2 text-xs rounded-s-lg grow"
                            disabled />
                        <button x-on:click="navigator.clipboard.writeText(url); copied = true" type="button"
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-gray-300 border-s-0 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <span x-show="!copied">@icon('bi-copy')</span>
                            <span x-show="copied" class="text-green-600">@icon('bi-check')</span>
                        </button>
                    </div>
                </div>
                <div class="flex-space-1 mt-3 justify-center">
                    <div class="col">
                        <a target="_blank" href="{{ $media->original_url }}" class="btn xs btn-blue px-1.5">
                            <i class="icon bi-box-arrow-up-right h-3"></i>
                            <span>{{ __('View') }}</span>
                        </a>
                    </div>
                    <div class="col">
                        <a wire:loading.remove wire:target="download" wire:click="download" type="button"
                            class="btn xs btn-green px-1.5">
                            <i class="icon bi-cloud-download h-3"></i>
                            <span wire:loading.remove wire:target="delete">
                                {{ __('Download') }}
                            </span>
                        </a>
                        <x-loader wire:loading wire:target="download" />
                    </div>
                    <div class="col">
                        <a wire:loading.remove wire:target="delete" wire:click="delete"class="btn xs btn-red px-1.5">
                            <i class="icon bi-trash-fill h-3"></i>
                            <span wire:loading.remove wire:target="delete">
                                {{ __('Delete') }}
                            </span>
                        </a>
                        <x-loader wire:loading wire:target="delete" />
                    </div>
                </div>
            </div>
        </div>
    @else
        <fgx:loader />
    @endif
    <x-slot name="footer">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary sm" x-on:click="closeModal">{{ __('Close') }}</button>
        </div>
    </x-slot>
</x-dialog>
