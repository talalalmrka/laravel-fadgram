<script setup lang="ts">
import { BlockType } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
const props = defineProps<{
    block: BlockType
    activeBlock?: BlockType
}>()
const atts = useAttributes(props.block);
</script>

<template>
    <div v-bind="$attrs" :data-theme="atts.theme"
        class="relative w-full flex flex-col items-center justify-center text-black-800 dark:text-white"
        :class="{ 'h-screen': atts.fullscreen }">
        <div class="absolute inset-0 bg-white/40 dark:bg-black/40"></div>
        <div class="flex flex-col items-center justify-center z-1 py-20">
            <div class="container mx-auto">
                <h1 v-if="atts.title" class="text-5xl text-gray-700 dark:text-white text-center">{{ atts.title }}</h1>
                <h5 v-if="atts.subtitle" class="text-2xl text-gray-700 dark:text-white text-center mt-4">{{
                    atts.subtitle }}</h5>
                <p v-if="atts.text" class="text-gray-700 dark:text-white text-center mt-4">{{ atts.text }}</p>
                <div class="mt-4 flex-space-2 flex-wrap justify-center">
                    <slot name="children"></slot>
                </div>
            </div>
        </div>
    </div>
</template>
