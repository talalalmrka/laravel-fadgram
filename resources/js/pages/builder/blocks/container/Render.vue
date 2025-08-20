<script setup lang="ts">
import { BlockType } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
const props = defineProps<{
    block: BlockType
    activeBlock?: BlockType
}>()
const atts = useAttributes(props.block);
</script>

<template>
    <div v-bind="$attrs" :class="[atts.type]">
        <slot name="children"></slot>
    </div>
</template>
