<script setup lang="ts">
import draggable from 'vuedraggable'
import {
    InspectorItem
} from '@/components'
import type {
    Block
} from '@/types'
const props = defineProps<{
    blocks: Block[];
    activeBlock?: Block;
}>();
</script>
<template>
    <draggable class="divide-y" tag="div" :list="blocks" :group="{ name: 'blocks' }" item-key="id" handle=".handle"
        v-bind="$attrs">
        <template #item="{ element, index }">
            <inspector-item :block="element" :active-block="activeBlock" :index="index" :move-up="index > 0"
                :move-down="(index + 1) < blocks.length" />
        </template>
    </draggable>
</template>
