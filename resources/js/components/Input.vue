<script setup lang="ts">
import { defineProps, defineEmits, computed, ref } from 'vue'
import Label from './Label.vue';
import Info from './Info.vue';
import Error from './Error.vue';

const props = defineProps<{
    modelValue: string | number | boolean;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    id?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | number | boolean): void;
}>();

const inputId = computed(() => props.id || `input-${Math.random().toString(36).substring(2, 9)}`);
const inputElement = ref<HTMLInputElement | null>(null);
defineExpose({
    inputElement
});
</script>
<template>
    <Label :for="inputId" :label="label" :icon="icon" :class="{ 'error': error }" />
    <input :id="inputId" v-bind="$attrs" ref="inputElement" :value="modelValue"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)" class="form-control"
        :class="{ 'error': error }" />
    <Info :info="info" :id="inputId" />
    <Error :error="error" />
</template>
