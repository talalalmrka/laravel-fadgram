@props([
    'title' => null,
    'titleIcon' => null,
    'show' => 'show',
    'class' => null,
    'headerClass' => null,
    'titleClass' => null,
    'bodyClass' => '',
    'footerClass' => '',
])
<div>
    @teleport('body')
        <div wire:show="{{ $show }}" wire:transition
            class="{{ css_classes(['modal fade show', $class => $class]) }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    @if ($title)
                        <div class="{{ css_classes(['modal-header', $headerClass => $headerClass]) }}">
                            <h5
                                class="{{ css_classes(['modal-title', $titleClass => $titleClass, 'flex-space-2' => $titleIcon]) }}">
                                @icon($titleIcon)
                                <span>{{ $title ?? '' }}</span>
                            </h5>
                            <button type="button" class="btn-close" x-on:click="$wire.$toggle('{{ $show }}')">
                                <i class="icon bi-x-lg"></i>
                            </button>
                        </div>
                    @endif
                    <div class="{{ css_classes(['modal-body', $bodyClass => $bodyClass]) }}">
                        {{ $slot }}
                    </div>
                    @if (isset($footer))
                        <div class="{{ css_classes(['modal-footer', $footerClass => $footerClass]) }}">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div><!-- Modal Dialog -->
        </div><!-- Modal -->
    @endteleport
    @teleport('body')
        <div class="modal-backdrop show" wire:show="{{ $show }}"
            x-on:click="$wire.$toggle('{{ $show }}')">
        </div>
    @endteleport
</div>
