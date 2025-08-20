@props([
    'showTitle' => true,
])
<x-dashboard-layout :title="$title ?? ''" :containerClass="$containerClass ?? ''" :showTitle="$showTitle">
    @push('head')
        @routes
        @vite(['resources/js/inertia.ts'])
        @inertiaHead
    @endpush
    @inertia
</x-dashboard-layout>
