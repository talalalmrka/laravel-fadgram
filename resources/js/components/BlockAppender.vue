<script setup lang="ts">
import { Block } from '@/types';
import EventBus from '@/types/event-bus';
defineProps<{
    block?: Block
}>()
</script>
<template>
    <button type="button" @click.stop="EventBus.emit('openAdd', block)" v-bind="$attrs"
        class="relative p-2 border-dashed border-2 hover:border-primary bg-transparent hover:bg-primary hover:text-white rounded-md transition-colors cursor-pointer flex items-center justify-center">
        <fg-icon icon="bi-plus-lg" />
    </button>
</template>
