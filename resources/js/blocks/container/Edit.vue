<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import { useOptions } from '@/composables/useOptions';
import { computed } from 'vue';
import {
    EditBlock,
    CollapsePanel,
    BreakpointSelectControl,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const {
    containerTypeOptions,
    gridColsOptions,
    gapOptions,
    colspanOptions,
} = useOptions();


const isGrid = computed(() => atts.value.type === 'grid')
const isCol = computed(() => atts.value.type === 'col')
</script>

<template>
    <edit-block :block="block">
        <collapse-panel title="Container">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fg-select v-model="atts.type" label="Type" :options="containerTypeOptions" class="sm" />
                </div>
                <div v-if="isGrid" class="col">
                    <breakpoint-select-control v-model="atts.cols" label="Columns" :options="gridColsOptions" />
                </div>
                <div v-if="isGrid" class="col">
                    <breakpoint-select-control v-model="atts.gap" label="Gap" :options="gapOptions" />
                </div>
                <div v-if="isCol" class="col">
                    <breakpoint-select-control v-model="atts.colspan" label="Colspan" :options="colspanOptions" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
