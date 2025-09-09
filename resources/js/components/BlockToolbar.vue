<script setup lang="ts">
import { useBlockIcon } from '@/composables/useBlocks';
import { Block } from '@/types';
import EventBus from '@/types/event-bus';
import { route } from 'ziggy-js';

const props = defineProps<{
    block: Block
}>()
const emit = defineEmits(['remove'])
const previewUrl = route('builder.block.preview', { ...props.block })
const icon = useBlockIcon(props.block.type)

const moveUp = () => {
    EventBus.emit('moveUp', props.block.id)
}
const moveDown = () => {
    EventBus.emit('moveDown', props.block.id)
}
</script>

<template>
    <div v-bind="$attrs"
        class="!flex-space-2 !text-sm !text-gray-700 !dark:text-gray-100 !px-3 !py-1.5 !border !absolute !top-0 !-translate-y-full !bg-gray-100 !dark:bg-gray-700 !justify-between">
        <div class="flex-space-2">
            <span class="handler cursor-move">
                <fg-icon icon="bi-arrows-move" />
            </span>
            <span>
                <fg-icon :icon="icon" />
            </span>
        </div>
        <div class="flex-space-2">
            <div class="flex flex-col text-xs items-center justify-center">
                <button @click="moveUp" type="button" class="p-0 leading-0">
                    <fg-icon icon="bi-chevron-up" />
                </button>
                <button @click="moveDown" type="button" class="p-0 leading-0">
                    <fg-icon icon="bi-chevron-down" />
                </button>
            </div>
            <a class="hover:link" :href="previewUrl" target="_blank" title="View block">
                <i class="icon bi-box-arrow-up-right"></i>
            </a>
        </div>
        <div class="flex-space-2">
            <button @click="emit('remove', block)" class="hover:text-red" type="button">
                <fg-icon icon="bi-trash" />
            </button>
        </div>
    </div>
</template>
