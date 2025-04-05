@props([
    'id' => uniqid('categories-list-'),
    'categories' => [],
    'model' => 'categories',
    'class' => '',
    'atts' => [],
    'value' => [],
])
<ul
    {{ attributes($atts)->merge([
        'id' => $id,
        'class' => css_classes(['categories-list', 'text-xs', $class => $class]),
    ]) }}>
    @foreach ($categories as $category)
        <li x-data="{ open: @js($category->hasAnyChild($value)) }">
            <div class="p-1 flex-space-1">
                @if ($category->children->isNotEmpty())
                    <button type="button" x-on:click="open = !open" :class="{ 'open': open }"
                        class="collapse-chevron p-0 flex items-center">
                        @icon('bi-chevron-right')
                    </button>
                @endif
                <input {{ $attributes }} type="checkbox" wire:model.live="{{ $model }}"
                    value="{{ $category->id }}" name="{{ $model }}[]">
                <label
                    class="whitespace-nowrap {{ $category->hasAnyChild($value) ? 'text-primary' : '' }}">{{ $category->name }}</label>
            </div>
            @if ($category->children->isNotEmpty())
                @component('components.select-categories-list', [
                    'categories' => $category->children,
                    'model' => $model,
                    'class' => 'ps-4 border-s border-gray-300 dark:border-gray-600',
                    'atts' => ['x-collapse', 'x-show' => 'open'],
                    'value' => $value,
                ])
                @endcomponent
            @endif
        </li>
    @endforeach
</ul>
