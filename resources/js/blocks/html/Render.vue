<script setup lang="ts">
import { Block } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
const props = defineProps<{
    block: Block
    activeBlock?: Block
}>()
const atts = useAttributes(props.block);
</script>

<template>
    <div v-bind="$attrs" v-html="atts.content"></div>
</template>
