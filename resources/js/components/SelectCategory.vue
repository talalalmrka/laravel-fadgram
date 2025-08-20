<script setup lang="ts">
import { CategoryType } from '@/types';
import { usePage } from '@inertiajs/vue3';

const props = defineProps<{

}>()
const page = usePage<{
    props: {
        categories: CategoryType[];
    }
}>();
const categories = page.props.categories as CategoryType[];
</script>

<template>

</template>

<style scoped></style>
