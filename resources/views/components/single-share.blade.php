@props([
    'model',
    'icon' => 'bi-share',
    'buttons' => share_buttons(),
    'class' => null,
    'atts' => [],
    'titleClass' => null,
    'borderColor' => 'primary',
])
@php
    $iconColorClass = text_class($borderColor);
@endphp
@if ($model->shareEnabled())
    <div
        {{ $attributes->merge(
            array_merge(
                [
                    'class' => css_classes(['mb-3', $class => $class]),
                ],
                $atts,
            ),
        ) }}>
        <div class="flex-space-2 mb-2">
            <h2
                class="{{ css_classes(['flex-space-2 text-base md:text-lg lg:text-xl mb-0' => $model->shareLabel(), $titleClass => $titleClass]) }}">
                @if ($icon)
                    @icon("bi-share $iconColorClass")
                @endif
                <span class="mobile:hidden">{{ $model->shareLabel() }}</span>
            </h2>
            <div class="flex-1 flex flex-space-2 flex-wrap justify-end">
                @foreach ($buttons as $button)
                    <a href="{{ $button->shareUrl($model) }}" title="{{ $button->name }}" target="_blank"
                        class="btn {{ $button->buttonClass() }} rounded-full flex items-center p-0 w-8 h-8 md:w-10 md:h-10">
                        @icon($button->icon)
                    </a>
                @endforeach
            </div>
        </div>
        <div class="flex items-center">
            <div class="{{ css_classes(['w-10 md:w-20 border-b-2', border_class($borderColor)]) }}"></div>
            <div class="grow border-b"></div>
        </div>
    </div>
@endif
