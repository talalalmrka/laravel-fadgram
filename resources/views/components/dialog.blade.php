@props([
    'title' => null,
    'class' => null,
    'headerClass' => '',
    'bodyClass' => '',
    'show' => 'show',
])
<div x-data="{
    closeModal() {
        $wire.$toggle('{{ $show }}');
    }
}">
    @teleport('body')
        <div wire:show="{{ $show }}" wire:transition class="modal fade show {{ $class ?? '' }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    @if ($title)
                        <div class="modal-header {{ $headerClass }}">
                            <h5 class="modal-title">{{ $title ?? '' }}</h5>
                            <button type="button" class="btn-close" x-on:click="closeModal">
                                <i class="icon bi-x-lg"></i>
                            </button>
                        </div>
                    @endif
                    <div class="modal-body {{ $bodyClass }}">
                        {{ $slot }}
                    </div>
                    @if (isset($footer))
                        {{ $footer }}
                    @endif
                </div>
            </div><!-- Modal Dialog -->
        </div><!-- Modal -->
    @endteleport
    @teleport('body')
        <div class="modal-backdrop show" wire:show="{{ $show }}" x-on:click="closeModal"></div>
    @endteleport
    @if (isset($after))
        {{ $after }}
    @endif
</div>
