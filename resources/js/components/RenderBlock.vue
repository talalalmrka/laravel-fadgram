<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { useBlockClass } from '@/composables/useBlockClass';
import { useHasChildren } from '@/composables/useBlocks';
import { useBlockStyle } from '@/composables/useBlockStyle';
import { Block } from '@/types';
import EventBus from '@/types/event-bus';
import { computed, defineAsyncComponent, h } from 'vue';
import {
    RenderBlocks,
    BlockAppender,
} from '@/components'

const props = defineProps<{
    block: Block
    activeBlock?: Block
}>();

const active = computed(() => props.activeBlock && props.activeBlock.id === props.block.id);

// composables
const atts = useAttributes(props.block);
const classObject = computed(() => useBlockClass(atts.value));
const styleObject = computed(() => useBlockStyle(atts.value));
const hasChildren = computed(() => useHasChildren(props.block.type));

// async component with fallback
const renderComponent = defineAsyncComponent({
    loader: () =>
        import(`@/blocks/${props.block?.type}/Render.vue`)
            .catch(() => {
                // alert(`Render component for block "${props.block.type}" not found!`);
                // return a fallback component so Vue doesn't crash
                return {
                    render() {
                        return h('div', { class: 'alert alert-error alert-soft' },
                            `Missing Render component for block "${props.block.type}"`
                        )
                    }
                }
            }),
    delay: 0
});
</script>

<template>
    <component :is="renderComponent" @click.stop.prevent="EventBus.emit('edit', block.id)" :data-block-id="block.id"
        :id="atts.htmlAnchor" :block="block" :active-block="activeBlock"
        :class="[classObject, { 'ring-2 ring-blue-500/50': active }]" :style="styleObject" :key="block.id"
        class="hover:ring-2 hover:ring-blue-500/50">
        <template v-if="hasChildren" #children>
            <render-blocks :blocks="block.children ?? []" :active-block="activeBlock" />
            <block-appender :block="block" v-show="active" class="z-50" />
        </template>
    </component>
</template>
