<script setup lang="ts">
import Draggable from 'vuedraggable'
import { useBlockIcon, useBlockLabel } from '@/composables/useBlocks';
import { BlockType } from '@/types';
import { computed, ref, watch } from 'vue';
import { useAttributes } from '@/composables/useAttributes';
import IconText from '@/components/IconText.vue';
import eventBus from '@/types/eventBus';

const props = defineProps<{
    block: BlockType
    activeBlock?: BlockType
}>()
const atts = useAttributes(props.block)

const emit = defineEmits(['edit', 'remove'])
const icon = useBlockIcon(props.block.type)
const label = computed(() => {
    const type = props.block.type;
    let label = type;
    switch (props.block.type) {
        case 'container':
            label = atts.value.type;
            break;
        case 'paragraph':
            label = atts.value.content ?? type;
            break;
        case 'heading':
            label = atts.value.title ?? type;
        case 'button':
            label = atts.value.label ?? type;
    }
    return label;
})
const open = ref<boolean>(false);
const active = computed(() => props.activeBlock && props.activeBlock.id === props.block.id)
const toggle = () => {
    open.value = !open.value
}
const edit = (block: BlockType) => {
    eventBus.emit('editBlock', block);
}
const activeBlockIsChild = () => {
    if (!props.activeBlock) return false;
    const findInChildren = (blocks: BlockType[]): boolean => {
        return blocks.some(block => {
            if (block.id === props.activeBlock?.id) return true;
            if (block.children) return findInChildren(block.children);
            return false;
        });
    };
    return props.block.children ? findInChildren(props.block.children) : false;
};

watch(() => props.activeBlock, (newActiveBlock: BlockType | undefined) => {
    if (newActiveBlock && activeBlockIsChild()) {
        open.value = true;
    }
}, { immediate: true });


</script>
<template>
    <div>
        <div class="flex-space-2 px-3 py-2"
            :class="{ 'bg-primary text-white': active, 'hover:bg-primary-50 hover:text-primary': !active }">
            <button v-show="block.children" type="button" @click="toggle" class="flex items-center justify-center">
                <i class="icon bi-chevron-right transition-transform duration-200" :class="{ 'rotate-90': open }"></i>
            </button>
            <div class="flex-1 flex-space-2 cursor-pointer handle overflow-hidden" @click.stop="edit(block)"
                @clickk.stop="emit('edit', block)">
                <IconText :icon="icon" :label="label" class="flex-1 overflow-hidden"
                    label-class="text-nowrap truncate" />
                <fg-badge v-if="atts.htmlAnchor" :label="atts.htmlAnchor" class="text-nowrap truncate" />
            </div>
            <button type="button" @click.stop="emit('remove', block)" class="flex items-center justify-center">
                <fg-icon icon="bi-trash" />
            </button>
        </div>
        <div v-if="block.children" v-show="open" class="mt-2 ms-4">
            <draggable v-model="block.children" item-key="id" handle=".handle" group="inspector" class="space-y-1">
                <template #item="{ element, index }">
                    <InspectorItem :block="element" :index="index" :active-block="activeBlock"
                        @edit="emit('edit', element)" @remove="emit('remove', element)" :key="element.id" />
                </template>
            </draggable>
        </div>
    </div>
</template>
