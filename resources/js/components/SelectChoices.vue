<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount } from 'vue'
import Choices from 'choices.js'
import 'choices.js/public/assets/styles/choices.css';


interface Option {
    value: string | number
    label: string
}

const props = defineProps<{
    id?: string;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    modelValue: string | number | Array<string | number> | undefined
    options: Option[]
    multiple?: boolean
    placeholder?: string
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: any): void
}>()
const selectId = ref(props.id || `fg-select-${Math.random().toString(36).substr(2, 9)}`);

const selectEl = ref<HTMLSelectElement | null>(null)
let choicesInstance: Choices | null = null

const isSelected = (value: string | number) => {
    if (props.multiple && Array.isArray(props.modelValue)) {
        return props.modelValue.includes(value)
    }
    return props.modelValue === value
}

const initializeChoices = () => {
    if (selectEl.value) {
        choicesInstance = new Choices(selectEl.value, {
            removeItemButton: props.multiple ?? false,
            placeholder: true,
            shouldSort: false,
            searchEnabled: true,
        })

        // Sync Vue model when selection changes
        selectEl.value.addEventListener('change', () => {
            const selected = choicesInstance?.getValue(true)
            emit('update:modelValue', selected)
        })
    }
}

onMounted(() => {
    initializeChoices()
})

onBeforeUnmount(() => {
    choicesInstance?.destroy()
})

watch(() => props.modelValue, (newVal) => {
    if (!choicesInstance) return

    // For external model updates
    choicesInstance.removeActiveItems()
    if (props.multiple && Array.isArray(newVal)) {
        newVal.forEach(val => {
            choicesInstance?.setChoiceByValue(String(val))
        })
    } else {
        choicesInstance.setChoiceByValue(String(newVal))
    }
})
</script>
<template>
    <fg-label :icon="icon" :label="label" :error="error" :for="selectId" />
    <select ref="selectEl" :multiple="multiple" :placeholder="placeholder" v-bind="$attrs">
        <option v-if="!multiple && placeholder" disabled selected hidden>{{ placeholder }}</option>
        <option v-for="option in options" :key="option.value" :value="option.value"
            :selected="isSelected(option.value)">
            {{ option.label }}
        </option>
    </select>
    <fg-info :info="info" />
    <fg-error :error="error" />
</template>
