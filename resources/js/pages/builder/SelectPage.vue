<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { PageType } from '@/types';

const page = usePage<{
    props: {
        page: PageType
        pages: PageType[]
    }
}>();
const pages = (page.props.pages ?? []) as PageType[];
const currentPage = page.props.page as PageType;
const options = computed(() => pages.map((item) => ({ label: item.name, value: item.id })));
const currentPageId = ref<string | null>(currentPage?.id ?? null);

watch(currentPageId, (newVal) => {
    router.visit(route('builder', { page: newVal }));
});
</script>
<template>
    <fg-rich-select v-model="currentPageId" class="sm" placeholder="Select page" :options="options" />
</template>
