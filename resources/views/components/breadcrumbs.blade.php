@props([
    'items' => null,
    'class' => null,
    'atts' => [],
    'containerClass' => null,
])
@php
    $crumbs = $items ?? breadcrumbs();
@endphp
@if (!empty($crumbs))
    <nav aria-label="breadcrumb"
        {{ $attributes->merge(['class' => css_classes(['breadcrumb', $containerClass => $containerClass])]) }}>
        <ol
            class="flex-space-1 flex-wrap text-xs md:text-sm text-muted-700 dark:text-muted-200 p-0 m-0 {{ css_classes([$class => $class]) }}">
            @foreach ($crumbs as $i => $item)
                @php
                    $label = data_get($item, 'label');
                    $icon = data_get($item, 'icon');
                    $url = data_get($item, 'url');
                @endphp
                <li class="flex items-center">
                    @if ($url)
                        <x-link :href="$url" :icon="$icon" :label="$label"
                            class="hover:underline flex items-center" />
                    @else
                        <span class="text-muted">
                            @if ($icon)
                                @icon("$icon me-1")
                            @endif
                            {{ $label }}
                        </span>
                    @endif

                    @if (!$loop->last)
                        <span class="mx-1 text-muted-400" aria-hidden="true">
                            @icon('bi-chevron-right')
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
