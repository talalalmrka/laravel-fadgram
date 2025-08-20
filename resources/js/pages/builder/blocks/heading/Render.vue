<script setup lang="ts">
import { BlockType } from '@/types';
import { computed } from 'vue';
import { useAttributes } from '@/composables/useAttributes';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
</script>

<template>
    <component :is="atts.tag || 'h2'" class="heading" v-bind="$attrs">
        <fg-icon v-if="atts.icon" :icon="atts.icon" />
        {{ atts.title && atts.title !== '' ? atts.title : 'Type title' }}
    </component>
</template>
