@props(['item'])
@if ($item->hasChildren())
    <x-dropdown :icon="$item->icon" :label="$item->name" :class="$item->class_name">
        @foreach ($item->children as $child)
            <x-dropdown-link :navigate="$child->navigate" :icon="$child->icon" :label="$child->name" :class="$child->class_name" :href="$child->href"
                :target="$child->target" title="{{ $child->name }}" />
        @endforeach
    </x-dropdown>
@else
    <x-nav-link :navigate="$item->navigate" :icon="$item->icon" :label="$item->name" :class="$item->class_name" :href="$item->href"
        :target="$item->target" title="{{ $item->name }}" />
@endif
