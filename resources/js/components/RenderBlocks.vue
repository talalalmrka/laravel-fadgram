<script setup lang="ts">
import {
    RenderBlock
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
    <render-block v-for="block in blocks" :block="block" :active-block="activeBlock" :key="block.id" />
</template>
