<script setup lang="ts">
import { useOptions } from '@/composables/useOptions';
import { computed, ref } from 'vue';
import { data_get, data_set, uniqid } from '@/helpers';
import {
    TabPanel,
} from '@/components'
import { breakpointTabs, sideOptions } from '@/composables/options';

const props = withDefaults(defineProps<{
    id?: string;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    modelValue: any;
    options?: Record<string, any>
}>(), {
    modelValue: {
        sm: {
            top: '',
            start: '',
            end: '',
            bottom: '',
        },
        md: {
            top: '',
            start: '',
            end: '',
            bottom: '',
        },
        lg: {
            top: '',
            start: '',
            end: '',
            bottom: '',
        },
        xl: {
            top: '',
            start: '',
            end: '',
            bottom: '',
        },
    }
})


const controlId = ref(props.id || uniqid('control-'));

</script>

<template>
    <fg-label :icon="icon" :label="label" :error="error" :for="controlId" />
    <tab-panel :tabs="breakpointTabs">
        <template v-for="tab in breakpointTabs" #[tab.name]>
            <div class="grid grid-cols-4 gap-3 py-2">
                <div v-for="side in sideOptions" class="col">
                    <fg-select v-model="modelValue[tab.name][side.name]" :label="side.label"
                        :options="data_get(options, `${tab.name}.${side.name}`, [])" class="xs" />
                </div>
            </div>
        </template>
    </tab-panel>
    <fg-info :info="info" />
    <fg-error :error="error" />
</template>
