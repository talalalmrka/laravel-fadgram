<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import {
    EditBlock,
    CollapsePanel,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Custom html">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-textarea v-model="atts.content" label="Custom html" rows="10" class="text-sm" dir="ltr" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
