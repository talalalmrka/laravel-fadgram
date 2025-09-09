<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { useBlockClass } from '@/composables/useBlockClass';
import { useHasChildren } from '@/composables/useBlocks';
import { useBlockStyle } from '@/composables/useBlockStyle';
import { Block } from '@/types';
import EventBus from '@/types/event-bus';
import { computed, defineAsyncComponent } from 'vue';
import {
    RenderBlocks,
    BlockAppender,
} from '@/components'
const props = defineProps<{
    block: Block
    activeBlock?: Block
}>();


const active = computed(() => props.activeBlock && props.activeBlock && props.activeBlock.id === props.block.id);

// composables (pass refs where appropriate)
const atts = useAttributes(props.block); // assuming composable accepts a ref
const classObject = computed(() => useBlockClass(atts.value));
const styleObject = computed(() => useBlockStyle(atts.value));
const hasChildren = computed(() => useHasChildren(props.block.type));

const renderComponent = defineAsyncComponent(() =>
    import(`@/blocks/${props.block?.type}/Render.vue`)
)
</script>

<template>
    <component :is="renderComponent" @click.stop.prevent="EventBus.emit('edit', block.id)" :data-block-id="block.id"
        :id="atts.htmlAnchor" :block="block" :active-block="activeBlock"
        :class="[classObject, { 'ring-2 ring-blue-500/50': active }]" :style="styleObject" :key="block.id"
        class="hover:ring-2 hover:ring-blue-500/50">
        <!-- pass the appender slot only when the block type supports children -->
        <template v-if="hasChildren" #children>
            <render-blocks :blocks="block.children ?? []" :active-block="activeBlock" />
            <block-appender :block="block" v-show="active" class="z-50" />
        </template>
    </component>
</template>
