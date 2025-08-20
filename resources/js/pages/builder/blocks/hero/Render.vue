<script setup lang="ts">
import { BlockType } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
import ServerRender from '../../ServerRender.vue';
const props = defineProps<{
    block: BlockType
    activeBlock?: BlockType
}>()
const atts = useAttributes(props.block);
</script>

<template>
    <ServerRender :block="block" />
</template>
