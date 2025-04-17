<script setup lang="ts">
import { computed } from 'vue';
import { defineProps, defineEmits } from 'vue'
import Label from './Label.vue';
import Info from './Info.vue';
import Error from './Error.vue';



//defineEmits(['update:modelValue']);

const props = defineProps<{
    modelValue?: string | number | boolean;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    id?: string;
    placeholder?: string;
    options?: Array<{ value: string | number | boolean; label: string }>;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | number | boolean): void;
}>();

const selectId = computed(() => props.id || `select-${Math.random().toString(36).substring(2, 9)}`);
</script>
<template>
    <Label :for="selectId" :label="label" :icon="icon" :class="{ 'error': error }" />
    <select :id="selectId" v-bind="$attrs" :value="modelValue"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)" class="form-control"
        :class="{ 'error': error }">
        <option v-if="placeholder" value="">
            {{ placeholder }}
        </option>
        <option v-for="option in options" :key="String(option.value)" :value="option.value">
            {{ option.label }}
        </option>
    </select>
    <Info :info="info" :id="selectId" />
    <Error :error="error" />
</template>
