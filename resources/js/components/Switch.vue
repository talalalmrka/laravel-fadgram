<script setup lang="ts">
import { computed, defineProps, defineEmits } from 'vue';
import Label from './Label.vue';
import Info from './Info.vue';
import Error from './Error.vue';

// Define the props using the generic type.
interface Props {
    id?: string;
    modelValue?: boolean | number | string;
    label?: string;
    info?: string;
    error?: string;
}
const props = defineProps<Props>();

// Define the emits using the  EmitType
type EmitType = (event: 'update:modelValue', value: boolean | number | string) => void;
const emit = defineEmits<EmitType>();
const switchId = computed(() => props.id || `select-${Math.random().toString(36).substring(2, 9)}`);
const internalValue = computed({
    get() {
        // Convert numeric/string values to boolean
        return Boolean(props.modelValue);
    },
    set(checked: boolean) {
        let newValue: boolean | number | string;

        // Preserve original value type
        switch (typeof props.modelValue) {
            case 'number':
                newValue = checked ? 1 : 0;
                break;
            case 'string':
                newValue = checked ? '1' : '0';
                break;
            default:
                newValue = checked;
        }

        emit('update:modelValue', newValue);
    },
});

function handleChange(e: Event) {
    const checked = (e.target as HTMLInputElement).checked;
    internalValue.value = checked; // Use the computed property setter
}
</script>
<template>
    <div class="input-container">
        <label class="switch-wrapper">
            <input :id="switchId" type="checkbox" class="switch-input" :class="{ 'has-error': error }" v-bind="$attrs"
                :checked="internalValue" @change="handleChange" />
            <span class="switch-slider"></span>
            <Label v-if="label" :for="switchId" :label="label" class="switch-label" />
        </label>

        <Info v-if="info && !error" :text="info" />

        <Error v-if="error" :text="error" />
    </div>
</template>

<style scoped>
.input-container {
    margin-bottom: 1rem;
    width: 100%;
}

.switch-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.switch-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-slider {
    position: relative;
    display: inline-block;
    width: 2.75rem;
    height: 1.5rem;
    background-color: #ccc;
    border-radius: 9999px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.switch-slider::before {
    content: "";
    position: absolute;
    left: 0.25rem;
    top: 50%;
    transform: translateY(-50%);
    height: 1rem;
    width: 1rem;
    background-color: white;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.switch-input:checked+.switch-slider {
    background-color: var(--color-primary);
}

.switch-input:checked+.switch-slider::before {
    transform: translate(1.25rem, -50%);
}

.switch-input:focus+.switch-slider {
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
}

.has-error+.switch-slider {
    background-color: #fecaca;
}

.has-error:checked+.switch-slider {
    background-color: #ef4444;
}

.switch-label {
    margin-bottom: 0;
    cursor: pointer;
}
</style>
