<x-dashboard-layout :title="$title ?? ''">
    @push('head')
        @routes
        @vite(['resources/js/inertia.ts'])
        @inertiaHead
    @endpush
    @inertia
</x-dashboard-layout>
