<script setup lang="ts">
import { BlockType } from '@/types'
import { computed, ref, watch } from 'vue';
import Draggable from 'vuedraggable'
import InspectorItem from './InspectorItem.vue';
const props = defineProps<{
    show: boolean
    blocks: BlockType[]
    activeBlock?: BlockType
}>()
const emit = defineEmits(['update:blocks', 'edit', 'remove', 'close', 'removeActive'])


const blocks = ref(props.blocks)
const edit = (block: BlockType) => {
    emit('edit', block)
}
const remove = (block: BlockType) => {
    emit('remove', block)
}
watch(blocks, (newBlocks) => {
    console.log('updated blocks', newBlocks);
    emit('update:blocks', newBlocks);
});
</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 start-0 w-80 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
        :class="{ '-translate-x-full': !show, 'translate-x-0': show }">
        <div class="flex-space-2 px-3 py-2 top-0 border-b bg-gray-50 dark:bg-gray-700">
            <div class="flex-1 flex-space-2 font-bold">
                <fg-icon icon="bi-list" />
                <span>Blocks</span>
            </div>
            <button type="button" @click="emit('close')">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
        <div class="flex-1 overflow-y-auto" @click.stop="emit('removeActive')">
            <draggable v-model="blocks" item-key="id" handle=".handle" group="inspector" class="space-y-1 pb-3">
                <template #item="{ element, index }">
                    <InspectorItem :block="element" :index="index" :active-block="activeBlock" @edit="edit"
                        @remove="remove" :key="element.attributes" />
                </template>
            </draggable>
        </div>
    </div>
</template>
