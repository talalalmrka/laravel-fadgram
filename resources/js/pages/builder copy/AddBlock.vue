<script setup lang="ts">
import { BaseBlock, BlockType } from '@/types'
import { computed, ref } from 'vue';
import { useBlocks, resolveBlock } from '@/composables/useBlocks';

const props = defineProps<{
    show: boolean
}>()
const emit = defineEmits(['addBlock', 'close'])
const blocks = useBlocks();
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

const addBlock = (block: BlockType) => {
    const newBlock = resolveBlock(block.type);
    emit('addBlock', newBlock)
}
</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 start-0 w-80 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
        :class="{ '-translate-x-full': !show, 'translate-x-0': show }">
        <div class="flex-space-2 px-3 py-2 top-0 border-b bg-gray-50 dark:bg-gray-700">
            <div class="flex-1 flex-space-2 font-bold">
                <fg-icon icon="bi-plus-lg" />
                <span>Add block</span>
            </div>
            <button type="button" @click="emit('close')">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
        <div class="px-3 py-4 flex-1 overflow-y-auto">
            <fg-input type="search" v-model="search" startIcon="bi-search" placeholder="Search" size="sm" />
            <div class="grid grid-cols-3 py-3">
                <div v-for="block in filteredBlocks"
                    class="col px-1 py-3 hover:bg-primary-100 hover:text-primary cursor-pointer"
                    v-on:click="addBlock(block)">
                    <div class="text-center">
                        <fg-icon :icon="block.icon" class="text-2xl" />
                    </div>
                    <div class="text-center text-sm">
                        {{ block.label }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
