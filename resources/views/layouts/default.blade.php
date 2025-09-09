@props([
    'title' => '',
    'description' => '',
])
<x-app-layout :title="$title ?? ''" :description="$description">
    <x-mobile-menu />
    @include('partials.header', [
        'class' => $navbarclass ?? 'header sticky top-0 bg-gray-50 dark:bg-gray-700 max-w-full z-50 shadow-xs',
        'logo_theme' => $logo_theme ?? 'dark',
    ])
    <main class="main min-h-[75vh]">
        {{ $slot }}
    </main>
    @include('partials.footer')
    @if (boolval(get_option('custom_css_enabled')))
        @push('head')
            <style>
                {!! get_option('custom_css') !!}
            </style>
        @endpush
    @endif
    @if (boolval(get_option('header_code_enabled')))
        @push('head')
            {!! get_option('header_code') !!}
        @endpush
    @endif
    @if (boolval(get_option('ads_auto_enabled')))
        @push('head')
            {!! get_option('ads_auto_code') !!}
        @endpush
    @endif
    @if (boolval(get_option('custom_js_enabled')))
        @push('head')
            <script>
                {!! get_option('custom_js') !!}
            </script>
        @endpush
    @endif
    @if (boolval(get_option('ads_above_content_enabled')))
        @push('above-content')
            {!! get_option('ads_above_content') !!}
        @endpush
    @endif
    @if (boolval(get_option('ads_below_content_enabled')))
        @push('below-content')
            {!! get_option('ads_below_content') !!}
        @endpush
    @endif
    @if (boolval(get_option('footer_code_enabled')))
        @push('footer')
            {!! get_option('footer_code') !!}
        @endpush
    @endif
    @if (isset($footer))
        {{ $footer }}
    @endif
</x-app-layout>
