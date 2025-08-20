@props([
    'model',
    'icon' => 'bi-tag',
    'class' => null,
    'atts' => [],
    'titleClass' => null,
    'borderColor' => 'primary',
])
@php
    $iconColorClass = text_class($borderColor);
@endphp
@if ($model->singleTagsEnabled())
    <div
        {{ $attributes->merge(
            array_merge(
                [
                    'class' => css_classes(['mb-3', $class => $class]),
                ],
                $atts,
            ),
        ) }}>
        @if (!empty($model->tagsLabel()))
            <h2
                class="{{ css_classes(['flex-space-2 text-base md:text-lg lg:text-xl mb-2' => $model->shareLabel(), $titleClass => $titleClass]) }}">
                @if ($icon)
                    @icon("bi-tag $iconColorClass")
                @endif
                <span>{{ $model->tagsLabel() }}</span>
            </h2>
        @endif
        <div class="flex items-center">
            <div class="{{ css_classes(['w-10 md:w-20 border-b-2', border_class($borderColor)]) }}"></div>
            <div class="grow border-b"></div>
        </div>
        <div class="flex-space-2 flex-wrap mt-2">
            {!! $model->tagsLinks(['class' => 'badge badge-primary']) !!}
        </div>
    </div>
@endif
