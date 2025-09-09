<script setup lang="ts">
import { Block } from '@/types';
import { ServerRender } from '@/components';

const props = defineProps<{
    block: Block
    activeBlock?: Block
}>()
</script>

<template>
    <server-render :block="block" />
</template>
