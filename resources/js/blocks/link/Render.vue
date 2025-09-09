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
    <a v-bind="$attrs" :href="atts.url" :target="atts.target" :title="atts.label"
        :class="[atts.type, { 'flex-space-2': atts.icon }]">
        <fg-icon v-if="atts.icon" />
        <span v-if="atts.label">{{ atts.label }}</span>
    </a>
</template>
