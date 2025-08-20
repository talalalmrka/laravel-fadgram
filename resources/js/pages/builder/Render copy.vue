<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { useBlockClass } from '@/composables/useBlockClass';
import { useHasChildren, useInnerBlocks, useInnerTypes } from '@/composables/useBlocks';
import { useBlockStyle } from '@/composables/useBlockStyle';
import BlockToolbar from '@/pages/builder/BlockToolbar.vue';
import BlockAppender from '@/pages/builder/BlockAppender.vue';
import RenderBlocks from '@/pages/builder/RenderBlocks.vue';
import { BlockType } from '@/types';
import { computed, defineAsyncComponent, ref, toRef, watch } from 'vue';
import Dump from '@/components/Dump.vue';

const props = defineProps<{
    block: BlockType
    activeBlock?: BlockType
}>();

const emit = defineEmits<{
    (e: 'edit', block: BlockType): void
    (e: 'remove', block: BlockType): void
}>();

// expose reactive refs for template convenience
const block = toRef(props, 'block');
const activeBlock = toRef(props, 'activeBlock');

const active = computed(() => activeBlock.value && activeBlock.value.id === block.value.id);

// composables (pass refs where appropriate)
const atts = useAttributes(props.block); // assuming composable accepts a ref
const classObject = computed(() => useBlockClass(atts.value));
const styleObject = computed(() => useBlockStyle(atts.value));
const hasChildren = computed(() => useHasChildren(block.value.type));

const renderComponent = defineAsyncComponent(() =>
    import(`@builder/blocks/${props.block?.type}/Render.vue`)
)

// local handlers that call emit (keeps logic centralized)
const edit = (b: BlockType) => emit('edit', b);
const remove = (b: BlockType) => emit('remove', b);

// children for RenderBlocks v-model — keep synced with incoming prop
const children = ref<BlockType[]>(block.value.children ?? []);

const inner = useInnerTypes(props.block.type);
watch(block, (newBlock) => {
    children.value = newBlock?.children ?? [];
});
</script>

<template>
    <section @click.stop="edit(block)" :id="block.id" class="relative hover:ring-primary hover:ring"
        :class="{ 'ring-primary/30 ring-2': active }">
        <BlockToolbar v-if="active" :block="block" @remove="remove" />
        <component :id="atts.htmlAnchor" :is="renderComponent" :block="block" :active-block="activeBlock" @edit="edit"
            @remove="remove" :class="classObject" :style="styleObject">
            <!-- pass the appender slot only when the block type supports children -->
            <template v-if="hasChildren" #children>
                <div class="space-y-3">
                    <Render v-for="child in block.children" :block="child" :key="child.id" :active-block="activeBlock"
                        @edit="edit" @remove="remove" />
                </div>
                <!-- <RenderBlocks v-model="children" :active-block="activeBlock" @edit="edit" @remove="remove" /> -->
                <BlockAppender :block="block" v-show="active" />
            </template>
        </component>
    </section>
</template>
