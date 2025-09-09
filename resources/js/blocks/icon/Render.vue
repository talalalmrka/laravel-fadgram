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
    <i v-bind="$attrs" class="icon" :class="['icon', atts.icon, atts.size]">
    </i>
</template>
