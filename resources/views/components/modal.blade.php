@props([
    'title' => null,
    'show' => 'show',
])
@teleport('body')
    <div class="modal-backdrop show" wire:show="{{ $show }}" x-on:click="$wire.$toggle('{{ $show }}')"></div>
@endteleport
@teleport('body')
    <div wire:show="{{ $show }}" wire:transition class="modal fade show">
        <div class="modal-dialog">
            <div class="modal-content">
                @if ($title)
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $title ?? '' }}</h5>
                        <button type="button" class="btn-close" x-on:click="$wire.$toggle('{{ $show }}')">
                            <i class="icon bi-x-lg"></i>
                        </button>
                    </div>
                @endif
                <div class="modal-body">
                    {{ $slot }}
                </div>
                @if (isset($footer))
                    <div class="modal-footer">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div><!-- Modal Dialog -->
    </div><!-- Modal -->
@endteleport
