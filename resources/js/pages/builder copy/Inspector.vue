<script setup lang="ts">
import { BlockType } from '@/types'
import { ref, watch } from 'vue';
import Draggable from 'vuedraggable'
import InspectorItem from './InspectorItem.vue';
import { useBlockLabel } from '@/composables/useBlocks';
const props = defineProps<{
    show: boolean
    blocks: BlockType[]
    activeBlock?: BlockType
}>()
const emit = defineEmits(['editBlock', 'deleteBlock', 'update:blocks', 'close'])
const blocks = ref(props.blocks)

const editBlock = (block: BlockType) => {
    // console.log('edit', block)
    emit('editBlock', block)
}
const deleteBlock = (block: BlockType) => {
    // console.log('delete', block)
    emit('deleteBlock', block)
}
// Watch for changes in blocks (e.g., after sorting) and emit update to parent
watch(blocks, (newBlocks) => {
    emit('update:blocks', newBlocks);
});

</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 start-0 w-72 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
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
        <div class="p-3 flex-1 overflow-y-auto">
            <draggable v-model="blocks" item-key="id" handle=".handle" class="space-y-1">
                <template #item="{ element, index }">
                    <InspectorItem :block="element" :index="index" @edit="editBlock" @delete="deleteBlock"
                        :active-block="activeBlock" />
                </template>
            </draggable>
        </div>
    </div>
</template>
