<script setup lang="ts">
import Draggable from 'vuedraggable'
import { useBlockIcon, useBlockLabel } from '@/composables/useBlocks';
import { BlockType } from '@/types';
import { computed, ref } from 'vue';

const props = defineProps<{
    block: BlockType
    activeBlock?: BlockType
}>()
const emit = defineEmits(['edit', 'delete'])

const icon = useBlockIcon(props.block.type)
const label = useBlockLabel(props.block.type)
const active = computed(() => props.activeBlock !== undefined && props.activeBlock.id === props.block.id)
const open = ref<boolean>(false);

const toggle = () => {
    open.value = !open.value
}

const deleteChild = (block: BlockType) => {
    const idx = props.block.children?.findIndex(b => b.id === block.id)
    if (idx && idx !== -1) {
        props.block.children?.splice(idx, 1)
    }
}

</script>
<template>
    <div>
        <div class="flex-space-2 px-3 py-2"
            :class="{ 'bg-primary text-white': active, 'hover:bg-primary-50 hover:text-primary': !active }">
            <button v-show="block.children" type="button" @click="toggle" class="flex items-center justify-center">
                <i class="icon bi-chevron-right transition-transform duration-200" :class="{ 'rotate-90': open }"></i>
            </button>
            <div class="flex-1 flex-space-2 cursor-pointer handle" @click="emit('edit', block)">
                <fg-icon :icon="icon" />
                <span class="text-sm">{{ label }}</span>
            </div>
            <button type="button" @click="emit('delete', block)" class="flex items-center justify-center">
                <fg-icon icon="bi-trash" />
            </button>
        </div>
        <div v-if="block.children" v-show="open" class="mt-2 ms-4">
            <draggable v-model="block.children" item-key="id" handle=".handle" class="space-y-1">
                <template #item="{ element, index }">
                    <InspectorItem :block="element" :index="index" @edit="emit('edit', element)"
                        @delete="deleteChild(element)" :active-block="activeBlock" />
                </template>
            </draggable>
        </div>
    </div>

</template>
