@props([
    'id' => '',
    'name' => '',
    'label' => null,
    'icon' => null,
    'placeholder' => 'Select an option...',
    'searchPlaceholder' => 'Search...',
    'options' => [],
    'selected' => null,
    'multiple' => false,
    'searchable' => true,
    'ajaxUrl' => null,
    'ajaxParams' => [],
    'minSearchLength' => 1,
    'debounceMs' => 300,
    'disabled' => false,
    'required' => false,
    'class' => '',
    'error' => false,
    'helpText' => '',
    'noOptionsText' => 'No options available',
    'loadingText' => 'Loading...',
    'clearable' => true,
    'maxItems' => null,
    'info' => null,
    'size' => null,
])

@php
    $id = $id ?: $name;
    // استخراج wire:model تلقائيًا لدعمه مع Livewire
    $modelAttr = collect($attributes->getAttributes())
        ->filter(fn($val, $key) => str_starts_with($key, 'wire:model'))
        ->first();

    $model = $modelAttr ? explode(':', $modelAttr)[0] : null;
@endphp
<x-fgx::label :for="$id" :icon="$icon" :required="$required" :label="$label" />

<div
    wire:ignore
    x-data="richSelect({
        name: '{{ $name }}',
        id: '{{ $id }}',
        placeholder: '{{ $placeholder }}',
        searchPlaceholder: '{{ $searchPlaceholder }}',
        options: @js($options),
        selected: @js($selected),
        multiple: {{ $multiple ? 'true' : 'false' }},
        searchable: {{ $searchable ? 'true' : 'false' }},
        ajaxUrl: '{{ $ajaxUrl }}',
        ajaxParams: @js($ajaxParams),
        minSearchLength: {{ $minSearchLength }},
        debounceMs: {{ $debounceMs }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        required: {{ $required ? 'true' : 'false' }},
        noOptionsText: '{{ $noOptionsText }}',
        loadingText: '{{ $loadingText }}',
        clearable: {{ $clearable ? 'true' : 'false' }},
        maxItems: {{ $maxItems ?: 'null' }},
        model: '{{ $attributes->whereStartsWith('wire:model')->first() }}',
    })"
    x-init="init()"
    class="relative {{ $class }}"
    x-on:click.away="closeDropdown()">
    <!-- Hidden input synced with Livewire -->
    <input
        type="hidden"
        x-ref="hiddenInput"
        name="{{ $name }}"
        {{ $attributes->whereStartsWith('wire:model') }}
        :value="multiple ? JSON.stringify(getSelectedValue()) : getSelectedValue()"
        {{ $required ? 'required' : '' }}>
    <div class="relative">
        <button
            type="button"
            x-on:click="toggleDropdown()"
            :disabled="disabled"
            class="{{ css_classes([
                'form-control',
                $size => $size,
                'error' => $errors->has($id),
                'has-end-icon',
                // 'has-start-icon' => $clearable && $selected,
                $class => $class,
            ]) }}">
            <!-- Selected items display -->
            <div class="flex items-center flex-wrap gap-1 min-h-[20px]">
                <template x-if="multiple && selectedItems.length > 0">
                    <div class="flex flex-wrap gap-1">
                        <template x-for="item in selectedItems" :key="item.value">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                <span x-text="item.label"></span>
                                <button
                                    type="button"
                                    @click.stop="removeItem(item)"
                                    class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-blue-400 hover:text-blue-600 hover:bg-blue-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </span>
                        </template>
                    </div>
                </template>

                <template x-if="!multiple && selectedItem">
                    <span x-text="selectedItem.label" class="text-gray-900"></span>
                </template>

                <template x-if="(!multiple && !selectedItem) || (multiple && selectedItems.length === 0)">
                    <span class="text-gray-500" x-text="placeholder"></span>
                </template>
            </div>

            <!-- Clear button -->
            <template x-if="clearable && ((!multiple && selectedItem) || (multiple && selectedItems.length > 0))">
                <button
                    type="button"
                    @click.stop="clearSelection()"
                    class="absolute right-8 top-1/2 transform -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </template>

            <!-- Dropdown arrow -->
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                <i class="icon bi-chevron-expand"></i>
            </span>
        </button>
    </div>

    <!-- Dropdown menu -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden"
        style="display: none;">
        <!-- Search input -->
        <template x-if="searchable">
            <div class="p-2 border-b">
                <div class="form-control-container">
                    <span class="start-icon">
                        <i class="icon bi-search"></i>
                    </span>
                    <input
                        type="search"
                        x-ref="searchInput"
                        x-model="searchQuery"
                        @input.debounce="handleSearch()"
                        :placeholder="searchPlaceholder"
                        class="form-control sm has-start-icon">
                </div>

            </div>
        </template>

        <!-- Loading state -->
        <template x-if="isLoading">
            <div class="p-4 text-center text-gray-500 text-sm">
                <div class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span x-text="loadingText"></span>
                </div>
            </div>
        </template>

        <!-- Options list -->
        <template x-if="!isLoading">
            <div class="max-h-48 overflow-y-auto">
                <template x-if="filteredOptions.length === 0">
                    <div class="p-4 text-center text-gray-500 text-sm" x-text="noOptionsText"></div>
                </template>

                <template x-for="(option, index) in filteredOptions" :key="index">
                    <button
                        type="button"
                        x-on:click="selectOption(option)"
                        class="w-full px-4 py-2 text-left text-sm hover:bg-blue-50 focus:bg-blue-50 focus:outline-none transition-colors duration-150"
                        :class="{
                            'bg-primary-100 text-primary-900': isSelected(option),
                            'text-gray-900': !isSelected(option)
                        }">
                        <div class="flex items-center">
                            <!-- Checkbox for multiple selection -->
                            <template x-if="multiple">
                                <div class="mr-3">
                                    <input
                                        type="checkbox"
                                        :checked="isSelected(option)"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        readonly>
                                </div>
                            </template>

                            <!-- Option content -->
                            <div class="flex-1">
                                <div x-text="option.label" class="font-medium"></div>
                                <template x-if="option.description">
                                    <div x-text="option.description" class="text-xs text-gray-500 mt-1"></div>
                                </template>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </template>
    </div>
</div>
<fgx:info :id="$id" :info="$info" />
<fgx:error :id="$id" />

@script
    <script>
        Alpine.data('richSelect', (config) => ({
            name: config.name,
            id: config.id,
            placeholder: config.placeholder,
            searchPlaceholder: config.searchPlaceholder,
            options: config.options || [],
            selected: config.selected,
            multiple: config.multiple,
            searchable: config.searchable,
            ajaxUrl: config.ajaxUrl,
            ajaxParams: config.ajaxParams || {},
            minSearchLength: config.minSearchLength,
            debounceMs: config.debounceMs,
            disabled: config.disabled,
            required: config.required,
            noOptionsText: config.noOptionsText,
            loadingText: config.loadingText,
            clearable: config.clearable,
            maxItems: config.maxItems,
            model: config.model,

            isOpen: false,
            searchQuery: '',
            isLoading: false,
            selectedItems: [],
            selectedItem: null,
            filteredOptions: [],
            debounceTimer: null,

            init() {
                this.initializeSelection();
                this.filteredOptions = [...this.options];
            },

            initializeSelection() {
                if (this.multiple) {
                    this.selectedItems = Array.isArray(this.selected) ?
                        this.selected.map(val => this.normalizeOption(val)) : [];
                } else {
                    this.selectedItem = this.selected ? this.normalizeOption(this.selected) : null;
                }
            },

            normalizeOption(val) {
                if (typeof val === 'object' && val !== null) return val;
                return this.options.find(opt => opt.value == val) || {
                    value: val,
                    label: val
                };
            },

            toggleDropdown() {
                if (this.disabled) return;
                this.isOpen = !this.isOpen;
                if (this.isOpen && this.searchable) {
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                }
            },

            closeDropdown() {
                this.isOpen = false;
            },

            selectOption(option) {
                if (this.multiple) {
                    const index = this.selectedItems.findIndex(item => item.value === option.value);
                    if (index >= 0) {
                        this.selectedItems.splice(index, 1);
                    } else {
                        if (!this.maxItems || this.selectedItems.length < this.maxItems) {
                            this.selectedItems.push(option);
                        }
                    }
                } else {
                    this.selectedItem = option;
                    this.closeDropdown();
                }

                this.updateHiddenInput();
            },

            removeItem(item) {
                this.selectedItems = this.selectedItems.filter(i => i.value !== item.value);
                this.updateHiddenInput();
            },

            clearSelection() {
                this.multiple ? this.selectedItems = [] : this.selectedItem = null;
                this.updateHiddenInput();
            },

            isSelected(option) {
                return this.multiple ?
                    this.selectedItems.some(i => i.value === option.value) :
                    this.selectedItem?.value === option.value;
            },

            getSelectedValue() {
                return this.multiple ?
                    this.selectedItems.map(i => i.value) :
                    this.selectedItem?.value || '';
            },

            updateHiddenInput() {
                const value = this.getSelectedValue();
                if (this.model && typeof $wire !== 'undefined') {
                    const path = this.model.replace(/.*?:/, '').replace(/"/g, '');
                    $wire.set(path, value);
                }
            },

            async handleSearch() {
                if (this.debounceTimer) clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(() => this.performSearch(), this.debounceMs);
            },

            async performSearch() {
                const query = this.searchQuery.trim();

                if (!this.searchable) return;

                if (!this.ajaxUrl || query.length < this.minSearchLength) {
                    this.filteredOptions = this.options.filter(option =>
                        option.label.toLowerCase().includes(query.toLowerCase())
                    );
                    return;
                }

                this.isLoading = true;
                try {
                    const params = new URLSearchParams({
                        search: query,
                        ...this.ajaxParams
                    });
                    const response = await fetch(`${this.ajaxUrl}?${params}`);
                    const data = await response.json();

                    this.filteredOptions = Array.isArray(data) ? data : data.data || data
                        .options || [];
                } catch (err) {
                    console.error('Search failed:', err);
                    this.filteredOptions = [];
                } finally {
                    this.isLoading = false;
                }
            },
        }));
    </script>
@endscript
