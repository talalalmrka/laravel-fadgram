<!DOCTYPE html>
<html {!! locale_attributes() !!}>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '' }} | {{ config('app.name', 'Fadgram starter kit') }}</title>
    <meta name="description" content="{{ $description ?? config('app.description') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/poppins/style.css') }}">
    @stack('head_before_scripts')
    @livewireStyles
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
    @stack('head')
    @stack('styles')
    @stack('scripts')
</head>

<body>
    {{ $slot }}
    @livewireScriptConfig
    @if (config('eruda.enabled'))
        <script src="{{ asset('assets/eruda/eruda.js') }}"></script>
        <script>
            eruda.init();
        </script>
    @endif

</body>

</html>
