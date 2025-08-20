<script setup lang="ts">
import { BlockType } from '@/types'
import { computed, onUnmounted, ref } from 'vue';
import { useBlocks, resolveBlock, useInnerBlocks, useHasChildren, useBlockAllowed } from '@/composables/useBlocks';
import eventBus from '@/types/eventBus';
import Toast from "fadgram-ui/helpers/toast";
const props = defineProps<{
    show: boolean
    activeBlock?: BlockType
}>()

const add = (block: BlockType) => {
    const resolvedBlock = resolveBlock(block.type);
    if (resolvedBlock) {
        eventBus.emit('addBlock', resolvedBlock);
    } else {
        Toast.warning(`could not resolve block: ${JSON.stringify(block)}`);
    }
}
onUnmounted(() => {
    eventBus.off('addBlock');
});
const emit = defineEmits(['close'])
const blocks = props.activeBlock ? useInnerBlocks(props.activeBlock.type) : useBlocks();
const search = ref('');
const filteredBlocks = computed(() => {
    if (!search.value) {
        return blocks;
    }
    const query = search.value.toLowerCase();
    return blocks.filter((block: BlockType) =>
        block.label?.toLowerCase().includes(query) ||
        (block.type && block.type.toLowerCase().includes(query))
    );
});
const title = computed(() => props.activeBlock ? `Add block to (${props.activeBlock.type})` : 'Add block');
</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 start-0 w-80 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
        :class="{ '-translate-x-full': !show, 'translate-x-0': show }">
        <div class="flex-space-2 px-3 py-2 top-0 border-b bg-gray-50 dark:bg-gray-700">
            <div class="flex-1 flex-space-2 font-bold">
                <fg-icon icon="bi-plus-lg" />
                <span>{{ title }}</span>
            </div>
            <button type="button" @click="emit('close')">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
        <div class="px-3 py-4 flex-1 overflow-y-auto">
            <fg-input type="search" v-model="search" startIcon="bi-search" placeholder="Search" size="sm" />
            <div v-if="filteredBlocks.length" class="grid grid-cols-3 py-3">
                <div v-for="block in filteredBlocks"
                    class="col px-1 py-3 hover:bg-primary-100 hover:text-primary cursor-pointer"
                    v-on:click="add(block)">
                    <div class="text-center">
                        <fg-icon :icon="block.icon" class="text-2xl" />
                    </div>
                    <div class="text-center text-sm">
                        {{ block.label }}
                    </div>
                </div>
            </div>
            <fg-alert v-else content="No blocks" soft class="mt-4" />
        </div>
    </div>
</template>
