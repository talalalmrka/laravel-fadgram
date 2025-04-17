@props([
    'categories' => [],
    'level' => 0,
])
@if (!empty($categories) && $categories->isNotEmpty())
    <div {{ $attributes->merge([
        'class' => css_classes(['p-2', 'ms-3 border-s' => $level > 0]),
    ]) }}>
        @foreach ($categories as $i => $category)
            <div>
                <fgx:checkbox id="categories-{{ $i }}" class="cursor-pointer" wire:model.live="categories"
                    label="{{ $category->name }}" value="{{ $category->id }}" />
                @php
                    $children = $category->children;
                @endphp
                <x-categories-list :categories="$children" :level="$level + 1" />
            </div>
        @endforeach
    </div>

@endif
