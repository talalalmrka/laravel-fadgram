<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import { computed } from 'vue';
import { useOptions } from '@/composables/useOptions';
import {
    EditBlock,
    CollapsePanel,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const {
    sizeOptions,
} = useOptions();

</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Icon">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-icon-picker v-model="atts.icon" label="Icon" size="xs" />
                </div>
                <div class="col">
                    <fg-select v-model="atts.size" label="Size" size="xs" :options="sizeOptions" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
