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
    borderSizeOptions,
    borderColorOptions,
    borderStyleOptions,
    borderRadiusOptions,
} = useOptions();
const controlId = ref(props.id || uniqid('control-'));
const emit = defineEmits<{
    (e: 'update:modelValue', value: any): void;
}>();
const initialModel = computed({
    get() {
        return props.modelValue ?? {}
    },
    set(val) {
        emit('update:modelValue', val);
    },
});
</script>

<template>
    <fg-label :icon="icon" :label="label" :error="error" :for="controlId" />
    <div class="grid grid-cols-4 gap-3 pb-2">
        <div class="col">
            <fg-select v-model="initialModel.borderSize" label="Size" :options="borderSizeOptions" class="xs" />
        </div>
        <div class="col">
            <fg-select v-model="initialModel.borderStyle" label="Style" :options="borderStyleOptions" class="xs" />
        </div>
        <div class="col">
            <fg-select v-model="initialModel.borderColor" label="Color" :options="borderColorOptions" class="xs" />
        </div>
        <div class="col">
            <fg-select v-model="initialModel.borderRadius" label="Radius" :options="borderRadiusOptions" class="xs" />
        </div>
    </div>
    <fg-info :info="info" />
    <fg-error :error="error" />
</template>
