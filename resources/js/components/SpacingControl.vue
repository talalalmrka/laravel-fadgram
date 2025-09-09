<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { data_get, uniqid } from '@/helpers';
import { TabPanel } from '@/components';
import { Spacing } from '@/types';
import { breakpointTabs, sideOptions } from '@/composables/options';

const props = withDefaults(
    defineProps<{
        id?: string;
        label?: string;
        icon?: string;
        info?: string;
        error?: string;
        modelValue?: Spacing;
        options: Record<string, any>;
    }>(),
    {
        modelValue: (): Spacing => ({
            sm: { top: '', start: '', end: '', bottom: '' },
            md: { top: '', start: '', end: '', bottom: '' },
            lg: { top: '', start: '', end: '', bottom: '' },
            xl: { top: '', start: '', end: '', bottom: '' },
        }),
    }
);

const emit = defineEmits<{
    (e: 'update:modelValue', v: Spacing): void;
}>();

const controlId = ref(props.id || uniqid('control-'));
const local = ref<Spacing>(JSON.parse(JSON.stringify(props.modelValue ?? {})));

watch(
    local.value,
    (v) => {

        emit('update:modelValue', JSON.parse(JSON.stringify(v)));
    },
    { deep: true }
);
const getLocalVal = (breakpoint: string, side: string) => {
    return data_get(local.value, `${breakpoint}.${side}`)
}
const setLocalVal = (breakpoint: string, side: string, val: any) => {

    if (!(local.value as any)[breakpoint]) (local.value as any)[breakpoint] = { top: '', start: '', end: '', bottom: '' };
    (local.value as any)[breakpoint][side] = val;
}
const getLocalOptions = (breakpoint: string, side: string) => {
    return data_get(props.options, `${breakpoint}.${side}`, [])
}
</script>

<template>
    <fg-label :icon="props.icon" :label="props.label" :error="props.error" :for="controlId" />
    <tab-panel :tabs="breakpointTabs">
        <template v-for="tab in breakpointTabs" :key="tab.name" v-slot:[tab.name]>
            <div class="grid grid-cols-4 gap-3 py-2">
                <div v-for="side in sideOptions" :key="side.name" class="col">
                    <fg-select :model-value="getLocalVal(tab.name, side.name)"
                        @update:modelValue="(val: string) => setLocalVal(tab.name, side.name, val)" :label="side.label"
                        :options="getLocalOptions(tab.name, side.name)" class="xs" />
                </div>
            </div>
        </template>
    </tab-panel>
    <fg-info :info="props.info" />
    <fg-error :error="props.error" />
</template>
