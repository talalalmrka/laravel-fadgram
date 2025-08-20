<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { PageType } from '@/types';

const page = usePage<{
    props: {
        page: PageType
    }
}>();

const currentPage = page.props.page as PageType;
const go = () => {
    router.visit(route('builder.classic', { page: currentPage.id }));
}
</script>
<template>
    <a :href="route('builder.classic', { page: currentPage.id })" class="hover:link-underline" title="Classic editor">
        <fg-icon icon="bi-pencil-square" />
    </a>
</template>
