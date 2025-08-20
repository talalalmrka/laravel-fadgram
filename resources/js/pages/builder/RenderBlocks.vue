<script setup lang="ts">
import { BlockType } from '@/types';
import Draggable from 'vuedraggable';
import Render from './Render.vue';
import { computed } from 'vue';
let props = defineProps<{
    modelValue: BlockType[];
    activeBlock?: BlockType;
}>()
/* const emit = defineEmits<{
    (e: 'update:modelValue', value: BlockType[]): void;
}>(); */
const emit = defineEmits([
    'update:modelValue',
    'edit',
    'remove',
]);
const edit = (block: BlockType) => {
    emit('edit', block)
}
const remove = (block: BlockType) => {
    emit('remove', block)
}
const blocks = computed({
    get() {
        return props.modelValue;
    },
    set(val) {
        emit('update:modelValue', val);
    },
});
</script>
<template>
    <div class="space-y-3">
        <Render v-for="(block, index) in blocks" :block="block" :index="index" :key="block.id"
            :active-block="activeBlock" @edit="edit" @remove="remove" />
    </div>
    <!-- <draggable v-bind="$attrs" v-model="blocks" item-key="id" handle=".handle" class="space-y-3">
        <template #item="{ element, index }">
            <Render :block="element" :index="index" :active-block="activeBlock" @edit="edit" @remove="remove" />
        </template>
</draggable> -->
</template>
