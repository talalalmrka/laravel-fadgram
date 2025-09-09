<script setup lang="ts">
import { InspectorDraggable } from '@/components'
import { ref, computed, watch, onMounted, onBeforeUnmount, onUnmounted } from "vue"
import type { Block } from "@/types"
import EventBus from "@/types/event-bus"
import { useBlockIcon, useBlockLabel } from "@/composables/useBlocks"
import { useAttributes, useChildren } from "@/composables/useAttributes"
import {
    IconText
} from '@/components'
import { route } from 'ziggy-js'
const props = withDefaults(defineProps<{
    block: Block;
    activeBlock?: Block;
    index: number;
    moveUp?: boolean;
    moveDown?: boolean;
}>(), {
    moveUp: true,
    moveDown: true,
})
const atts = useAttributes(props.block)
const icon = useBlockIcon(props.block.type)
const label = computed(() => {
    const type = props.block.type
    let label = useBlockLabel(type)
    switch (props.block.type) {
        case 'container':
            label = atts.value.type && atts.value.type !== '' ? atts.value.type : 'Container (no class)'
            break
        case 'paragraph':
            label = atts.value.content
            break
        case 'heading':
            label = atts.value.title
            break
        case 'button':
            label = atts.value.label
            break
    }
    return label
})

const previewUrl = computed(() => route('builder.block.preview', JSON.parse(JSON.stringify(props.block))))
const open = ref<boolean>(false)
const active = computed(
    () => props.activeBlock && props.activeBlock.id === props.block.id
)
const toggle = () => {
    open.value = !open.value
}
const activeBlockIsChild = () => {
    if (!props.activeBlock) return false;
    const findInChildren = (blocks: Block[]): boolean => {
        return blocks.some(block => {
            if (block.id === props.activeBlock?.id) return true;
            if (block.children) return findInChildren(block.children);
            return false;
        });
    };
    return props.block.children ? findInChildren(props.block.children) : false;
};
watch(() => props.activeBlock, (val: Block | undefined) => {
    if (val && activeBlockIsChild()) {
        open.value = true;
    }
}, { immediate: true });

onMounted(() => {
    EventBus.on('expandAll', () => {
        open.value = true
    })
    EventBus.on('collapseAll', () => {
        open.value = false
    })
})

onUnmounted(() => {
    EventBus.off('expandAll')
    EventBus.off('collapseAll')
})
</script>
<template>
    <div>
        <div @click.stop="EventBus.emit('edit', block.id)" @dblclick.stop="toggle"
            class="flex-space-2 px-3 py-2 text-sm cursor-pointer" :class="{
                'bg-primary text-white': active,
                'bg-white hover:bg-primary-50 hover:text-primary': !active,
            }">
            <button v-show="block.children" type="button" @click="toggle" class="flex items-center justify-center">
                <i class="icon bi-chevron-right transition-transform duration-200" :class="{ 'rotate-90': open }"></i>
            </button>
            <span class="handle flex items-center justify-center cursor-move">
                <i class="icon bi-grip-vertical"></i>
            </span>
            <fg-icon :icon="icon" />
            <div class="flex-1 flex-space-2 cursor-pointer overflow-hidden">
                <span class="flex-1 overflow-hidden text-nowrap truncate" label-class="text-nowrap truncate">
                    {{ label }}
                </span>
                <fg-badge v-if="atts.htmlAnchor" xs pill :label="atts.htmlAnchor"
                    class="text-nowrap truncate max-w-20" />
            </div>
            <div class="flex-space-2 text-sm">
                <button type="button" title="Duplicate (⌘D)" @click.stop="EventBus.emit('duplicate', block.id)"
                    class="icon-link">
                    <fg-icon icon="bi-copy" />
                </button>
                <span class="flex flex-col text-xs justify-between">
                    <button type="button" title="Move up (⌘↑)" @click.stop="EventBus.emit('moveUp', block.id)"
                        class="icon-link" :disabled="!moveUp">
                        <fg-icon icon="bi-chevron-up" />
                    </button>
                    <button type="button" title="Move down (⌘↓)" @click.stop="EventBus.emit('moveDown', block.id)"
                        class="icon-link" :disabled="!moveDown">
                        <fg-icon icon="bi-chevron-down" />
                    </button>
                </span>
                <a title="Preview" :href="previewUrl" class="icon-link" target="_blank">
                    <fg-icon icon="bi-box-arrow-up-right" />
                </a>
                <button type="button" title="Save pattern" @click.stop="EventBus.emit('savePattern', block)"
                    class="icon-link">
                    <fg-icon icon="bi-cloud-download" />
                </button>
                <button type="button" title="Remove (⌘⌫)" @click.stop="EventBus.emit('remove', block.id)"
                    class="icon-link">
                    <fg-icon icon="bi-trash" />
                </button>
            </div>
        </div>
        <inspector-draggable v-show="open" :blocks="block.children ?? []" class="ms-5" :active-block="activeBlock" />
    </div>
</template>
