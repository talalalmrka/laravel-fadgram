<script setup lang="ts">
import CollapsePanel from '@/components/CollapsePanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { BlockType } from '@/types';
import EditorPanel from '../../EditorPanel.vue';
import { useOptions } from '@/composables/useOptions';
import { computed } from 'vue';
import Dump from '@/components/Dump.vue';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
const {
    containerTypeOptions,
    breakpoints,
    gridColsOptions,
    gapOptions,
    colspanOptions,
} = useOptions();
const cols = computed<Record<string, any>>({
    get() {
        return atts.value.cols ?? {
            sm: undefined,
            md: undefined,
            lg: undefined,
            xl: undefined,
        };
    },
    set(val) {
        atts.value.cols = val;
    },
});
const gap = computed<Record<string, any>>({
    get() {
        return atts.value.gap ?? {
            sm: undefined,
            md: undefined,
            lg: undefined,
            xl: undefined,
        };
    },
    set(val) {
        atts.value.gap = val;
    },
});
const colspan = computed<Record<string, any>>({
    get() {
        return atts.value.colspan ?? {
            sm: undefined,
            md: undefined,
            lg: undefined,
            xl: undefined,
        };
    },
    set(val) {
        atts.value.colspan = val;
    },
});
</script>

<template>
    <EditorPanel :block="block">
        <CollapsePanel title="Container">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fg-select v-model="atts.type" label="Type" :options="containerTypeOptions" class="sm" />
                </div>
                <div class="col" v-if="atts.type === 'grid'">
                    <div class="grid grid-cols-1 gap-3">
                        <div class="col">
                            <fg-label label="Columns" />
                            <div class="grid grid-cols-4 gap-3 p-2">
                                <div v-for="breakpoint in breakpoints" class="col">
                                    <fg-select v-model="cols[breakpoint]" :label="breakpoint"
                                        :options="gridColsOptions[breakpoint] ?? []" class="xs" />
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <fg-label label="Gap" />
                            <div class="grid grid-cols-4 gap-3 p-2">
                                <div v-for="breakpoint in breakpoints" class="col">
                                    <fg-select v-model="gap[breakpoint]" :label="breakpoint"
                                        :options="gapOptions[breakpoint] ?? []" class="xs" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" v-if="atts.type === 'col'">
                    <fg-label label="Colspan" />
                    <div class="grid grid-cols-4 gap-3 p-2">
                        <div v-for="breakpoint in breakpoints" class="col">
                            <fg-select v-model="colspan[breakpoint]" :label="breakpoint"
                                :options="colspanOptions[breakpoint] ?? []" class="xs" />
                        </div>
                    </div>
                </div>
            </div>
        </CollapsePanel>
    </EditorPanel>
</template>
