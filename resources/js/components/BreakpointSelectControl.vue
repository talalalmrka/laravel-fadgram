<script setup lang="ts">
import { useOptions } from '@/composables/useOptions';
import { ref, watch } from 'vue';
import { data_get, uniqid } from '@/helpers';
import { Breakpoint } from '@/types';

const props = withDefaults(defineProps<{
    id?: string;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    modelValue?: Record<Breakpoint, any>;
    options?: Record<string, any>
}>(), {
    modelValue: () => ({
        sm: '',
        md: '',
        lg: '',
        xl: '',
    }),
    options: () => ({}),
})

const emit = defineEmits<{
    (e: 'update:modelValue', v: Record<Breakpoint, any>): void;
}>();

const {
    breakpointTabs,
} = useOptions();

const controlId = ref(props.id || uniqid('control-'));
const local = ref<Record<Breakpoint, any>>(JSON.parse(JSON.stringify(props.modelValue ?? {})));
watch(
    local.value,
    (v) => {
        emit('update:modelValue', JSON.parse(JSON.stringify(v)));
    },
    { deep: true }
);
const getLocalVal = (breakpoint: string) => {
    return data_get(local.value, breakpoint, '')
}
const setLocalVal = (breakpoint: string, val: any) => {
    if (typeof local.value !== 'object') {
        local.value = {
            sm: '',
            md: '',
            lg: '',
            xl: '',
        }
    }
    (local.value as any)[breakpoint] = val;
}
const getLocalOptions = (breakpoint: string) => {
    return data_get(props.options, breakpoint, [])
}
</script>

<template>
    <fg-label :icon="icon" :label="label" :error="error" :for="controlId" />
    <div class="grid grid-cols-4 gap-3 py-2">
        <div v-for="tab in breakpointTabs" class="col">
            <fg-select :model-value="getLocalVal(tab.name)"
                @update:modelValue="(val: string) => setLocalVal(tab.name, val)" :label="tab.name"
                :options="getLocalOptions(tab.name)" class="xs" />
        </div>
    </div>
    <fg-info :info="info" />
    <fg-error :error="error" />
</template>
