<!DOCTYPE html>
<html {!! locale_attributes() !!}>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($title ?? '') . ' | ' . get_option('name') }}</title>
    <meta name="description" content="{{ $description ?? get_option('description') }}">
    @if (get_option('disable_search_engines', false))
        <meta name="robots" content="noindex, nofollow">
    @endif
    <x-favicon />
    <link rel="stylesheet" href="{{ route('fonts-style') }}">
    @stack('head_before_scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $color = config('theme.color');
    @endphp
    @if ($color)
        <style>
            :root,
            :host {
                --color-primary: var(--color-{{ $color }}-600);
                --color-primary-50: var(--color-{{ $color }}-50);
                --color-primary-50: var(--color-{{ $color }}-50);
                --color-primary-100: var(--color-{{ $color }}-100);
                --color-primary-200: var(--color-{{ $color }}-200);
                --color-primary-300: var(--color-{{ $color }}-300);
                --color-primary-400: var(--color-{{ $color }}-400);
                --color-primary-500: var(--color-{{ $color }}-500);
                --color-primary-600: var(--color-{{ $color }}-600);
                --color-primary-700: var(--color-{{ $color }}-700);
                --color-primary-800: var(--color-{{ $color }}-800);
                --color-primary-900: var(--color-{{ $color }}-900);
                --color-primary-950: var(--color-{{ $color }}-950);
            }
        </style>
    @endif
    @if (get_option('eruda_enabled', config('eruda.enabled')))
        <script src="{{ asset('assets/eruda/eruda.js') }}"></script>
        <script>
            eruda.init();
        </script>
    @endif
    @stack('head')
    @stack('styles')
    @stack('scripts')
</head>
@php
    $font_family = get_option('font_family');
    $font_smoothing = get_option('font_smoothing');
    $font_size = get_option('font_size');
@endphp

<body class="font-{{ $font_family }} {{ $font_smoothing }} {{ $font_size }}" x-data="{ mobileMenu: false }">
    {{ $slot }}
    @stack('footer')
</body>

</html>
