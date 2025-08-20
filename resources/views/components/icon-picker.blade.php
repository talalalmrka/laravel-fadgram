@props([
    'id' => uniqid('icon-picker-'),
    'name' => null,
    'icon' => null,
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'autofocus' => false,
    'autocomplete' => null,
    'required' => false,
    'disabled' => false,
    'class' => null,
    'atts' => [],
    'info' => null,
    'container_class' => null,
    'container_atts' => [],
    'group_class' => null,
    'group_atts' => [],
    'dropdown_class' => null,
    'dropdown_atts' => [],
    'size' => null,
])
@php
    $model = $attributes->whereStartsWith('wire:model')->first();
@endphp
<x-fgx::label :for="$id" :icon="$icon" :required="$required" :label="$label" />
<div x-cloak x-data="IconPicker({ model: @js($model), value: @js($value) })"
    {{ attributes($container_atts)->merge([
        'class' => css_classes(['dropdown inited overflow-visible w-full', $container_class => $container_class]),
    ]) }}
    x-on:click.away="open = false">
    <div class="input-group w-full {{ $size }} {{ $group_class }}">
        <button type="button"
            class="text-gray-800 dark:text-white bg-gray-100 border-gray-100 dark:bg-gray-600 dark:border-gray-600 w-10"
            x-on:click="toggle">
            <i class="icon w-4 h-4 self-center" :style="currentIconStyle"></i>
        </button>
        <input
            {{ $attributes->merge(
                array_merge(
                    [
                        'x-ref' => 'input',
                        'class' => css_classes(['form-control', $class => $class]),
                        'x-on:keyup' => 'inputChanged',
                        'x-on:change' => 'inputChanged',
                    ],
                    $atts,
                ),
            ) }}>
    </div>
    <!-- Dropdown -->
    <div x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-10 mt-2 w-auto bg-white dark:bg-gray-800 rounded-md shadow-sm border border-gray-200 dark:border-gray-600 {{ $dropdown_class }}">
        <div class="bg-gray-100 dark:bg-gray-700 p-1">
            <div class="form-control-container">
                <span class="start-icon">
                    <i class="icon bi-search"></i>
                </span>
                <input type="search" class="form-control xs pill has-start-icon" x-model="search"
                    placeholder="{{ __('Search') }}" x-on:input="" />
            </div>
        </div>
        <div class="grid grid-cols-5 gap-3 p-2">
            <template x-for="(icon, index) in pageIcons" :key="index">
                <button type="button" x-on:click="selectIcon(icon)"
                    class="flex flex-col items-center justify-center w-7 h-7 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                    :class="{ 'bg-primary text-bg-primary': value === icon }" :title="icon">
                    <i class="icon text-xl" :style="iconStyle(icon)"></i>
                </button>
            </template>
            <div x-show="pageIcons.length === 0" class="col-span-5 text-center py-4 text-gray-500">
                {{ __('No icons found') }}
            </div>
        </div>
        <div x-show="pages" class="flex-space-2 items-center justify-between text-xs bg-gray-100 dark:bg-gray-700 p-1">
            <button type="button"
                class="flex items-center justify-center rounded-full p-1 hover:bg-gray-200 dark:hover:bg-primary-600 transition-colors"
                x-on:click.prevent="prevPage">
                <i class="icon bi-chevron-left rtl:rotate-270"></i>
            </button>
            <span x-text="page+'/'+pages"></span>
            <button x-show="page < pages" type="button"
                class="flex items-center justify-center rounded-full p-1 hover:bg-gray-200 dark:hover:bg-primary-600 transition-colors"
                x-on:click.prevent="nextPage">
                <i class="icon bi-chevron-right rtl:rotate-270"></i>
            </button>
        </div>
    </div>
</div>
@pushOnce('scripts')
    @vite(['resources/js/icon-picker.js'])
@endPushOnce
{{-- @pushOnce('scripts')
    @vite(['resources/js/icon-picker.js'])
@endPushOnce --}}
