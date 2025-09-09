<script setup lang="ts">
import { Block } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
import { ServerRender } from '@/components';
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
</script>

<template>
    <server-render :block="block" />
</template>
