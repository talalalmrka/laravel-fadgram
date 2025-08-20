<script setup lang="ts">
import { BlockType } from '@/types';
import eventBus from '@/types/eventBus';
import { onMounted, onUnmounted, ref } from 'vue';
const props = defineProps<{
    block: BlockType
    // active: boolean
}>()
const active = ref(false)
const edit = () => {
    eventBus.emit('editBlock', props.block);
}
onMounted(() => {
    eventBus.on('editBlock', (block: BlockType) => {
        if (block.id === props.block.id) {
            active.value = true
        }
    });
});

onUnmounted(() => {
    eventBus.off('editBlock');
});


</script>

<template>
    <div @click="edit" :class="[{
        'container': !block.fluid,
        'container-fluid': block.fluid,
        'ring-primary/50 ring-3 rounded': active,
    }, block.className]" class="relative hover:ring-primary/50 hover:ring-3 hover:rounded">
        <!-- <BlockRender v-for="child in block.children" :block="child" @click="edit"
                    :active="block.id === activeBlock?.id" :data-block-id="block.id" /> -->
    </div>
</template>
