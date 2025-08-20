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
    <a v-if="atts.url" v-bind="$attrs" :href="atts.url" :target="atts.target" :title="atts.label" class="btn"
        :class="[atts.color, atts.size, { 'flex-space-2': atts.icon }]">
        <fg-icon v-if="atts.icon" />
        <span v-if="atts.label">{{ atts.label }}</span>
    </a>
    <button v-else v-bind="$attrs" class="btn" :class="[atts.color, atts.size, { 'flex-space-2': atts.icon }]">
        <fg-icon v-if="atts.icon" />
        <span v-if="atts.label">{{ atts.label }}</span>
    </button>
</template>
