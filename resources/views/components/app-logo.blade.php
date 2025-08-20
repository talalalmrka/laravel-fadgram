@props([
    'id' => uniqid('logo-'),
    'width' => null,
    'height' => null,
    'showLabel' => get_option('logo_label_enabled', false),
    'label' => get_option('name'),
    'theme' => 'dark',
    'atts' => [],
    'navigate' => true,
    'class' => '',
    'labelClass' => null,
])
@php
    // $src = $theme === 'light' ? logo_light() : logo();
    $src = $theme === 'light' ? logo_light() : logo();
    $logo_key = $theme == 'light' ? 'logo' : 'logo_light';
    $width = $width ?? get_option('logo_width');
    $width = $width ?? 'auto';
    $width = is_numeric($width) ? $width . 'px' : $width;
    $height = $height ?? get_option('logo_height');
    $height = $height ?? 'auto';
    $height = is_numeric($height) ? $height . 'px' : $height;
    $label = get_option('name', __('FadGram'));
@endphp
<a {{ $navigate ? 'wire:navigate' : '' }} {!! $attributes->merge(
    array_merge($atts, [
        'id' => $id,
        'href' => route('home'),
        'title' => $label,
        'class' => css_classes(['flex-space-2', $class => $class]),
    ]),
) !!}>
    <img src="{{ $src }}" style="{{ css_styles(["width: $width", "height: $height"]) }}" alt="{{ $label }}"
        class="dark:invert dark:brightness-0" />
    @if ($showLabel)
        <span
            class="{{ css_classes(['flex-1', 'truncate', $labelClass => $labelClass]) }}">{{ $label }}</span>
    @endif
</a>
