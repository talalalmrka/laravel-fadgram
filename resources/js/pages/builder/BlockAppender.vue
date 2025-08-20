<script setup lang="ts">
import { BlockType } from '@/types';
import eventBus from '@/types/eventBus';

const props = defineProps<{
    block: BlockType
}>()

const add = () => {
    eventBus.emit('openAddBlock', props.block);
}
</script>

<template>
    <button type="button" @click.stop="add" v-bind="$attrs"
        class="relative p-2 border-dashed border-2 hover:border-primary bg-transparent hover:bg-primary hover:text-white rounded-md transition-colors cursor-pointer flex items-center justify-center">
        <fg-icon icon="bi-plus-lg" />
    </button>
</template>
