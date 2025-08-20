<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount, computed } from 'vue';
import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.css';

interface Option {
    value: string;
    label: string;
}

const props = withDefaults(defineProps<{
    id?: string;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    options?: Option[];
    apiUrl?: string;
    apiParams?: Record<string, any>;
    modelValue?: string | string[] | number | number[];
    multiple?: boolean;
    config?: Record<string, any>;
    fetchOnMounted?: boolean;
    placeholder?: string;
}>(), {
    options: () => [],
    multiple: false,
    config: () => ({}),
    apiParams: () => ({}),
    fetchOnMounted: true,
    modelValue: undefined,
    placeholder: 'Select an option',
});

const emit = defineEmits(['update:modelValue', 'fetch-error', 'fetch-success']);
const selectId = ref(props.id || `fg-select-${Math.random().toString(36).substr(2, 9)}`);

// COMPUTED: Normalize modelValue to string or string[]
const normalizedModelValue = computed(() => {
    if (props.modelValue === undefined || props.modelValue === null) {
        return props.multiple ? [] : '';
    }
    // Convert numbers to strings to match Choices.js expectations
    if (props.multiple) {
        return Array.isArray(props.modelValue)
            ? props.modelValue.map(String)
            : [String(props.modelValue)];
    }
    return String(props.modelValue);
});

// COMPUTED: Merge config with placeholder
const mergedConfig = computed(() => ({
    removeItemButton: true,
    placeholderValue: props.placeholder,
    ...props.config,
}));

// Refs
const selectElement = ref<HTMLSelectElement | null>(null);
const choices = ref<Choices | null>(null);
const ignoreEvent = ref(false);
const loading = ref(false);
const fetchError = ref<string | null>(null);
const internalOptions = ref<Option[]>(props.options);

// Initialize Choices.js
onMounted(() => {
    if (!selectElement.value) return;

    choices.value = new Choices(selectElement.value, {
        ...mergedConfig.value,
        choices: internalOptions.value,
    });

    // Set initial value safely
    if (normalizedModelValue.value) {
        try {
            choices.value.setValue(normalizedModelValue.value);
        } catch (err) {
            console.error('Error setting initial value:', err);
        }
    }

    // Handle change events
    selectElement.value.addEventListener('change', handleChange);

    if (props.apiUrl && props.fetchOnMounted) {
        fetchOptions();
    }
});

// Watch for option changes
watch(internalOptions, (newOptions) => {
    if (choices.value && Array.isArray(newOptions)) {
        try {
            // Ensure newOptions is in the correct format
            const validOptions = newOptions.filter(
                (opt) => typeof opt === 'object' && 'value' in opt && 'label' in opt
            );
            choices.value.setChoices(validOptions, 'value', 'label', true);
        } catch (err) {
            console.error('Error setting choices:', err);
        }
    }
});

// Watch for value changes
watch(normalizedModelValue, (newValue) => {
    if (ignoreEvent.value || !choices.value) return;
    ignoreEvent.value = true;
    try {
        choices.value.setValue(newValue);
    } catch (err) {
        console.error('Error updating value:', err);
    }
    ignoreEvent.value = false;
});

// Watch for placeholder changes
watch(() => props.placeholder, (newPlaceholder) => {
    if (choices.value) {
        choices.value.config.placeholderValue = newPlaceholder;
        choices.value.init();
    }
});

// Handle select changes
function handleChange() {
    if (ignoreEvent.value || !choices.value) return;

    const selectedValue = choices.value.getValue(true);
    ignoreEvent.value = true;
    emit('update:modelValue', selectedValue);
    ignoreEvent.value = false;
}

// Fetch options from API
async function fetchOptions() {
    if (!props.apiUrl) return;

    loading.value = true;
    fetchError.value = null;

    try {
        const url = new URL(props.apiUrl);
        Object.entries(props.apiParams).forEach(([key, value]) => {
            url.searchParams.append(key, String(value));
        });

        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);

        const data = await response.json();

        // Validate and transform API response
        if (!Array.isArray(data)) {
            throw new Error('API response must be an array of options');
        }

        // Transform data to ensure it matches Option interface
        const transformedOptions: Option[] = data.map((item) => {
            if (typeof item === 'object' && item !== null && 'value' in item && 'label' in item) {
                return { value: String(item.value), label: String(item.label) };
            }
            // Handle unexpected formats (e.g., numbers or strings)
            const value = String(item);
            return { value, label: value };
        });

        internalOptions.value = transformedOptions;
        emit('fetch-success', transformedOptions);
    } catch (err) {
        const errorMsg = (err as Error).message;
        fetchError.value = errorMsg;
        emit('fetch-error', errorMsg);
    } finally {
        loading.value = false;
    }
}

// Expose refresh function
function refreshOptions() {
    fetchOptions();
}

// Cleanup
onBeforeUnmount(() => {
    if (choices.value) {
        choices.value.destroy();
    }
    if (selectElement.value) {
        selectElement.value.removeEventListener('change', handleChange);
    }
});

defineExpose({ refreshOptions });
</script>

<template>
    <fg-label :icon="icon" :label="label" :error="error" :for="selectId" />
    <div>
        <select :multiple="multiple" ref="selectElement" :id="selectId"></select>
        <div v-if="loading" class="choices-loading">Loading options...</div>
        <div v-if="fetchError" class="choices-error">Error loading options: {{ fetchError }}</div>
    </div>
    <fg-info :info="info" />
    <fg-error :error="error" />
</template>

<style scoped>
.choices-loading,
.choices-error {
    padding: 8px 12px;
    font-size: 0.875rem;
    margin-top: 5px;
    border-radius: 4px;
}

.choices-loading {
    background-color: #f0f9ff;
    color: #0284c7;
}

.choices-error {
    background-color: #fef2f2;
    color: #dc2626;
}
</style>
