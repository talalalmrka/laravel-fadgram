<x-app-layout :title="$title ?? ''">
    <slot name="style">
        @vite(['resources/css/inertia.css'])
    </slot>
    @push('head')
        @routes
        @vite(['resources/js/inertia.ts'])
        @inertiaHead
    @endpush
    @inertia
</x-app-layout>
