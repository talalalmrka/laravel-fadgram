<script setup lang="ts">
import { ref, computed, watch, nextTick } from 'vue'

// Define interfaces for type safety
interface Option {
    value: string | number;
    label: string;
}

interface Props {
    modelValue: Option | Option[] | null;
    options?: Option[];
    placeholder?: string;
    multiple?: boolean;
    apiUrl?: string;
    limit?: number
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    options: () => [],
    placeholder: 'Select an option',
    multiple: false,
    apiUrl: '',
    limit: 5,
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: Option | Option[] | null): void;
}>()

const isOpen = ref<boolean>(false)
const searchQuery = ref<string>('')
const searchInput = ref<HTMLInputElement | null>(null)
const filteredOptions = ref<Option[]>(props.options)

const isMultiple = computed(() => props.multiple)

const selectedItems = computed<Option[]>({
    get: () => (props.multiple ? (props.modelValue as Option[] || []) : props.modelValue ? [props.modelValue as Option] : []),
    set: (value: Option[]) => {
        emit('update:modelValue', props.multiple ? value : value[0] || null)
    },
})

const displayValue = computed(() => {
    if (props.multiple && !isOpen.value) {
        return ''
    }
    return props.modelValue && !Array.isArray(props.modelValue) && !isOpen.value
        ? props.modelValue.label
        : searchQuery.value || ''
})

watch(
    () => props.options,
    (newOptions: Option[]) => {
        filteredOptions.value = newOptions
    },
    { immediate: true }
)

const openDropdown = () => {
    isOpen.value = true
    nextTick(() => searchInput.value?.focus())
}

const toggleDropdown = () => {
    isOpen.value = !isOpen.value
    if (isOpen.value) {
        nextTick(() => searchInput.value?.focus())
    }
}

const handleSearch = async (event: Event) => {
    const target = event.target as HTMLInputElement
    searchQuery.value = target.value
    if (searchQuery.value) {
        isOpen.value = true
    } else {
        isOpen.value = false
    }
    if (props.apiUrl) {
        try {
            const url = new URL(props.apiUrl)
            if (searchQuery.value) {
                url.searchParams.append('q', searchQuery.value)
                url.searchParams.append('limit', `${props.limit}`)
            }
            const response = await fetch(url.toString())
            if (!response.ok) throw new Error('Network response was not ok')
            const data = await response.json()
            filteredOptions.value = data.map((item: any) => ({
                value: item.id || item.value,
                label: item.name || item.label,
            }))
        } catch (error) {
            console.error('AJAX search failed:', error)
            filteredOptions.value = props.options
        }
    } else {
        filteredOptions.value = props.options.filter(option =>
            option.label.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    }
}

const selectOption = (option: Option) => {
    if (props.multiple) {
        const index = selectedItems.value.findIndex(item => item.value === option.value)
        if (index === -1) {
            selectedItems.value = [...selectedItems.value, option]
        } else {
            selectedItems.value = selectedItems.value.filter(item => item.value !== option.value)
        }
    } else {
        selectedItems.value = [option]
        isOpen.value = false
        searchQuery.value = ''
        filteredOptions.value = props.options
    }
}

const removeItem = (item: Option) => {
    selectedItems.value = selectedItems.value.filter(i => i.value !== item.value)
}

const isSelected = (option: Option) => {
    return selectedItems.value.some(item => item.value === option.value)
}

// Close dropdown when clicking outside
const handleClickOutside = (event: MouseEvent) => {
    if (!(event.target as HTMLElement).closest('.relative')) {
        isOpen.value = false
        searchQuery.value = ''
        filteredOptions.value = props.options
    }
}

watch(isOpen, (newVal: boolean) => {
    if (newVal) {
        document.addEventListener('click', handleClickOutside)
    } else {
        document.removeEventListener('click', handleClickOutside)
    }
})
</script>
<template>
    <div class="relative">
        <!-- Input for single/multiple selection and search -->
        <div class="form-control" :class="{ 'cursor-pointer': !isOpen }" v-bind="$attrs">
            <div class="flex items-center flex-wrap gap-1">
                <!-- Selected items for multiple selection -->
                <template v-if="isMultiple && selectedItems.length">
                    <span v-for="item in selectedItems" :key="item.value"
                        class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                        {{ item.label }}
                        <button type="button" class="ml-1 focus:outline-none" @click.stop="removeItem(item)">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                </template>
                <!-- Input for search or display -->
                <input type="text" :value="displayValue" :placeholder="placeholder"
                    class="outline-none text-gray-900 text-sm p-1 inline-flex w-auto"
                    :class="{ 'cursor-pointer': !isOpen, 'cursor-text': isOpen }" @focus="handleSearch"
                    @input="handleSearch" ref="searchInput" />
            </div>
            <!-- Dropdown arrow -->
            <!-- <div class="absolute right-2 top-1/2 transform -translate-y-1/2">
                <svg class="w-5 h-5 text-gray-500" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div> -->
        </div>

        <!-- Dropdown menu -->
        <div v-if="isOpen"
            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
            <ul class="text-gray-900 text-sm list-none p-0">
                <li v-for="option in filteredOptions" :key="option.value"
                    class="px-4 py-2 hover:bg-blue-50 cursor-pointer" :class="{ 'bg-blue-100': isSelected(option) }"
                    @click="selectOption(option)">
                    {{ option.label }}
                </li>
                <li v-if="!filteredOptions.length" class="px-4 py-2 text-gray-500">
                    No options available
                </li>
            </ul>
        </div>
    </div>
</template>
