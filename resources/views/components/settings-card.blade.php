@props([
    'title' => null,
    'icon' => null,
    'class' => null,
    'bodyClass' => null,
])

<fgx:card
    {{ $attributes->merge([
        'class' => css_classes(['h-full', $class => $class]),
    ]) }}>
    @if ($title || $icon)
        <fgx:card-header :title="$title" :icon="$icon" class="text-primary" />
    @endif
    <div class="{{ css_classes(['card-body', $bodyClass]) }}">
        {!! $slot !!}
    </div>
</fgx:card>
