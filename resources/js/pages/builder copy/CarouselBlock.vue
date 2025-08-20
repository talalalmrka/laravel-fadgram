<script setup lang="ts">
import Draggable from 'vuedraggable'

import { BlockType } from '@/types';
// import HeroAction from './HeroAction.vue';
import { resolveBlock } from '@/composables/useBlocks';
// import { useThemeOptions } from '@/composables/useThemeOptions';
import ImagePicker from '@/components/ImagePicker.vue';
import { uniqid } from '@/helpers/uniqid';

const props = defineProps<{
    block: BlockType
}>()
const emit = defineEmits(['edit'])
// const themeOptions = useThemeOptions()
const addSlide = () => {
    const newSlide = resolveBlock('slide', {
        icon: 'bi-window-stack',
        id: uniqid('block-'),
        title: 'Slide ' + (props.block.children?.length ?? 1) + ' title',
        subtitle: 'Slide ' + (props.block.children?.length ?? 1) + ' subtitle',
        url: '',
        image: '',
    });
    props.block.children?.push(newSlide);
};
const removeSlide = (block: BlockType) => {
    const idx = props.block.children?.findIndex(b => b.id === block.id)
    if (idx && idx !== -1) {
        props.block.children?.splice(idx, 1)
    }
}
const editSlide = (block: BlockType) => {
    console.log('edit', block)
    emit('edit', block)
}
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fg-switch v-model="block.autoplay" label="Autoplay" />
        </div>
        <div class="col">
            <fg-switch v-model="block.controls" label="Controls" />
        </div>
        <div class="col">
            <fg-switch v-model="block.indicators" label="Indicators" />
        </div>
        <div class="col">
            <fg-select v-model="block.transition" label="Transition" :options="[
                {
                    label: 'Slide',
                    value: 'slide',
                },
                {
                    label: 'Fade',
                    value: 'fade',
                },
            ]" />
        </div>
        <div class="col">
            <fg-input type="number" v-model="block.duration" label="Duration" />
        </div>
        <div class="col">
            <fg-input type="number" v-model="block.interval" label="Interval" />
        </div>
        <div class="col">
            <fg-label label="Slides" />
            <div class="form-control">
                <draggable v-if="block.children" v-model="block.children" item-key="id" handle=".handle"
                    class="space-y-2">
                    <template #item="{ element, index }">
                        <div class="flex-space-2 px-3 py-1 shadow-xs border rounded bg-white dark:bg-gray-700">
                            <div class="flex-1 flex-space-2 cursor-pointer handle" @click="editSlide(element)">
                                <fg-icon icon="bi-window-stack" />
                                <span class="text-sm">{{ element.title }}</span>
                            </div>
                            <button type="button" @click="removeSlide(element)"
                                class="flex items-center justify-center text-red hover:text-red-700">
                                <fg-icon icon="bi-trash" />
                            </button>
                        </div>
                    </template>
                </draggable>

                <button @click="addSlide" type="button" class="btn xs mt-2 btn-outline-primary">
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
