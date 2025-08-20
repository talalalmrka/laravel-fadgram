<script setup lang="ts">
import Draggable from 'vuedraggable'

import { BlockType } from '@/types';
import HeroAction from './HeroAction.vue';
import { resolveBlock } from '@/composables/useBlocks';
import { useThemeOptions } from '@/composables/useThemeOptions';
import ImagePicker from '@/components/ImagePicker.vue';

const props = defineProps<{
    block: BlockType
}>()
const emit = defineEmits(['edit'])
const themeOptions = useThemeOptions()
const addAction = () => {
    const newAction = resolveBlock('button');
    props.block.children?.push(newAction);
};
const removeAction = (block: BlockType) => {
    const idx = props.block.children?.findIndex(b => b.id === block.id)
    if (idx && idx !== -1) {
        props.block.children?.splice(idx, 1)
    }
}
const editAction = (block: BlockType) => {
    console.log('edit', block)
    emit('edit', block)
}
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fg-switch v-model="block.fullscreen" label="Fullscreen" />
        </div>
        <div class="col">
            <fg-select v-model="block.theme" label="Theme" :options="themeOptions" class="sm" />
        </div>
        <div class="col">
            <fg-input type="text" v-model="block.title" size="sm" label="Title" placeholder="Block title" />
        </div>
        <div class="col">
            <fg-input type="text" v-model="block.subtitle" size="sm" label="Subtitle" placeholder="Block subtitle" />
        </div>
        <div class="col">
            <fg-textarea v-model="block.text" size="sm" label="Text" placeholder="Block text" />
        </div>
        <div class="col">
            <fg-input v-model="block.color" size="sm" label="Text color" placeholder="Text color" />
        </div>
        <div class="col">
            <fg-input v-model="block.bgcolor" size="sm" label="Background color" placeholder="Background color" />
        </div>
        <div class="col">
            <ImagePicker v-model="block.image" label="Image" />
        </div>
        <div class="col">
            <fg-label label="Actions" />
            <div class="form-control">
                <draggable v-if="block.children" v-model="block.children" item-key="id" handle=".handle"
                    class="space-y-2">
                    <template #item="{ element, index }">
                        <HeroAction @delete="removeAction" @edit="editAction" :block="element" :index="index" />
                    </template>
                </draggable>

                <button @click="addAction" type="button" class="btn xs mt-2 btn-outline-primary">
                    <fg-icon icon="bi-plus-lg" />
                    <span>Add</span>
                </button>
            </div>

        </div>
        <div class="col">
            <fg-input v-model="block.className" size="sm" label="Css classes" />
        </div>
    </div>
</template>
