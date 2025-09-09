<script setup lang="ts">
import { useOptions } from '@/composables/useOptions';
import { computed, ref } from 'vue';
import { uniqid } from '@/helpers';

const props = defineProps<{
    id?: string;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    modelValue: Record<string, any>
}>()

const {
    shadowSizeOptions,
    shadowColorOptions,
} = useOptions();
const controlId = ref(props.id || uniqid('control-'));
</script>

<template>
    <fg-label :icon="icon" :label="label" :error="error" :for="controlId" />
    <div class="grid grid-cols-2 gap-3 pb-2">
        <div class="col">
            <fg-select v-model="modelValue.shadowSize" label="Size" :options="shadowSizeOptions" class="xs" />
        </div>
        <div class="col">
            <fg-select v-model="modelValue.shadowColor" label="Color" :options="shadowColorOptions" class="xs" />
        </div>
    </div>
    <fg-info :info="info" />
    <fg-error :error="error" />
</template>
