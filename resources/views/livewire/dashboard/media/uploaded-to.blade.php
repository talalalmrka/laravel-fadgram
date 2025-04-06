@props([
    'media' => null,
])
@if ($media)
    {!! model_link($media->model) !!}
@endif
