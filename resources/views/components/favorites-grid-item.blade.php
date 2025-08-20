@props(['favorite', 'class' => null, 'atts' => []])
@php
    $model = $favorite->model;
@endphp
@if (instance_post($model))
    <x-posts-grid-item :post="$model" :class="$class" />
@endif
@if (instance_book($model))
    <x-books-grid-item :book="$model" :class="$class" />
@endif
@if (instance_quote($model))
    <x-quotes-grid-item :quote="$model" :class="$class" />
@endif
@if (instance_author($model))
    <x-authors-grid-item :author="$model" :class="$class" />
@endif
@if (instance_category($model))
    <x-categories-grid-item :category="$model" :class="$class" />
@endif
