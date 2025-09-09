<script setup lang="ts">
import { Block } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
import { flat } from '@/helpers';
import { computed } from 'vue';
import { useBlockClass } from '@/composables/useBlockClass';
const props = defineProps<{
    block: Block
    activeBlock?: Block
}>()
const atts = useAttributes(props.block);
const className = computed(() => {
    const type = atts.value.type;
    const cols = flat(atts.value.cols).filter(Boolean);
    const gap = flat(atts.value.gap).filter(Boolean);
    const colspan = flat(atts.value.colspan).filter(Boolean);

    const isGrid = type === 'grid';
    const isCol = type === 'col';

    return [
        type,
        ...(isGrid ? [...cols, ...gap] : []),
        ...(isCol ? colspan : []),
    ].filter(Boolean);
});

</script>

<template>
    <div v-bind="$attrs" :class="className">
        <slot name="children"></slot>
    </div>
</template>
