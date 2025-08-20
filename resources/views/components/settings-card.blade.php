@props([
    'title' => null,
    'icon' => null,
])

<fgx:card {{ $attributes->merge([
    'class' => css_classes([
        'h-full',
    ])
]) }}>
    @if ($title || $icon)
        <fgx:card-header :title="$title" :icon="$icon" class="text-primary" />
    @endif
    <div class="card-body">
        {!! $slot !!}
    </div>
</fgx:card>
