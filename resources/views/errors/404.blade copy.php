{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Ooops Paage Not Found')) --}}

<x-default-layout :title="__('Not Found')">
    <div class="flex flex-col h-full items-center justify-center">
        <div class="max-w-2xl mx-auto text-center py-16">
            <h1 class="text-6xl font-bold mb-4">404</h1>
            <p class="text-xl mb-8">Page not found</p>

            <a class="route-link btn btn-primary" href="{{ url('/') }}">
                <i class="icon bi-house"></i>
                <span>{{ __('Home') }}</span>
            </a>
        </div>
    </div>


</x-default-layout>
