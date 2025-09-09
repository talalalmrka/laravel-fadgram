@props([
    'title' => '',
    'description' => '',
])
@php
    $og = og_data([
        'title' => $title ?? the_title(),
        'description' => $description ?? get_option('description'),
    ]);
@endphp
<!DOCTYPE html>
<html {!! locale_attributes() !!}>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($title ?? the_title()) . ' | ' . get_option('name') }}</title>
    <meta name="description" content="{{ $description ?? get_option('description') }}">
    @if (get_option('disable_search_engines', false))
        <meta name="robots" content="noindex, nofollow">
    @endif
    @foreach ($og as $k => $v)
        @if (!empty($v))
            <meta property="og:{{ $k }}" content="{{ $v }}">
        @endif
    @endforeach
    <x-favicon />
    <link rel="stylesheet" href="{{ route('style') }}">
    @stack('head_before_scripts')
    @if (isset($style))
        {{ $style }}
    @else
        @vite(['resources/css/app.css'])
    @endif
    @stack('styles')
    @vite(['resources/js/app.js'])
    @if (get_option('eruda_enabled', config('eruda.enabled')))
        <script src="{{ asset('assets/eruda/eruda.js') }}"></script>
        <script>
            eruda.init();
        </script>
    @endif
    @stack('scripts')
    @stack('head')
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
