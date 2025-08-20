@props(['model', 'class' => null, 'atts' => []])
@if ($model->nextPrevEnabled())
    <div
        {{ $attributes->merge(
            array_merge(
                [
                    'class' => css_classes(['flex-space-2 flex-wrap mx-auto mt-5 pt-2 pb-0 min-h-8 text-sm', $class => $class]),
                ],
                $atts,
            ),
        ) }}>
        @if ($model->prevItem())
            <a class="flex-1 border rounded p-3 hover:shadow text-start"
                href="{{ $model->prevItem()->permalink }}" aria-label="{{ $model->prevItem()->name }}">
                <div class="hint">
                    <i class="icon bi-chevron-left me-1"></i>
                    <span>{{ $model->prevLabel() }}</span>
                </div>
                <div class="link">
                    {{ $model->prevItem()->name }}
                </div>
            </a>
        @endif
        @if ($model->nextItem())
            <a class="flex-1 border rounded p-3 hover:shadow text-end" href="{{ $model->nextItem()->permalink }}"
                aria-label="{{ $model->nextItem()->name }}">
                <div class="hint">
                    <span>{{ $model->nextLabel() }}</span>
                    <i class="icon bi-chevron-right ms-1"></i>
                </div>
                <div class="link">
                    <span class="external-link">
                        <span>{{ $model->nextItem()->name }}</span>
                    </span>
                </div>
            </a>
        @endif
    </div>
@endif
