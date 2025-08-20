<script setup lang="ts">
import Dump from '@/components/Dump.vue';
import { BlockType } from '@/types';
import PostsGrid from './PostsGrid.vue';
import { computed, ref, watch } from 'vue';
import QuotesGrid from './QuotesGrid.vue';
import BooksGrid from './BooksGrid.vue';
import TextBlock from './TextBlock.vue';
import CategoriesGrid from './CategoriesGrid.vue';
import AuthorsGrid from './AuthorsGrid.vue';
import HeroBlock from './HeroBlock.vue';
import ButtonBlock from './ButtonBlock.vue';
import { useBlockIcon, useBlockLabel } from '@/composables/useBlocks';
import CarouselBlock from './CarouselBlock.vue';
import CarouselSlideBlock from './CarouselSlideBlock.vue';
import ContainerBlock from './ContainerBlock.vue';
const props = defineProps<{
    show: boolean
    block?: BlockType
}>()
const emit = defineEmits(['edit', 'close'])
const icon = useBlockIcon(props.block?.type)
const label = useBlockLabel(props.block?.type)
const edit = (block: BlockType) => {
    console.log('edit', block)
    emit('edit', block)
}
</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 end-0 w-72 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
        :class="{ 'translate-x-full': !show, 'translate-x-0': show }">
        <div class="flex-space-2 px-3 py-2 top-0 border-b bg-gray-50 dark:bg-gray-700">
            <div class="flex-1 flex-space-2 font-bold">
                <fg-icon :icon="icon" />
                <span>{{ label }}</span>
            </div>
            <button type="button" @click="emit('close')">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
        <div v-if="block" class="px-3 py-4 flex-1 overflow-y-auto">
            <PostsGrid v-if="block.type === 'posts_grid'" :block="block" />
            <QuotesGrid v-else-if="block.type === 'quotes_grid'" :block="block" />
            <QuotesGrid v-else-if="block.type === 'quotes_gallery'" :block="block" />
            <BooksGrid v-else-if="block.type === 'books_grid'" :block="block" />
            <TextBlock v-else-if="block.type === 'text'" :block="block" />
            <CategoriesGrid v-else-if="block.type === 'categories_grid'" :block="block" />
            <AuthorsGrid v-else-if="block.type === 'authors_grid'" :block="block" />
            <ButtonBlock v-else-if="block.type === 'button'" :block="block" />
            <HeroBlock v-else-if="block.type === 'hero'" :block="block" @edit="edit" />
            <CarouselBlock v-else-if="block.type === 'carousel'" :block="block" @edit="edit" />
            <CarouselSlideBlock v-else-if="block.type === 'slide'" :block="block" @edit="edit" />
            <ContainerBlock v-else-if="block.type === 'container'" :block="block" />
            <Dump v-else="block">{{ block }}</Dump>
        </div>
    </div>
</template>
