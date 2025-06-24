<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { MenuType } from '@/types/types';
import { route } from 'ziggy-js';

const page = usePage<{ props: { menus: MenuType[]; menu: MenuType } }>();
const menus = (page.props.menus ?? []) as MenuType[];
const menu = page.props.menu as MenuType;
const options = computed(() => menus.map((item) => ({ label: item.name, value: item.id })));
const selectedMenuId = ref<string | null>(menu?.id ?? null);

watch(selectedMenuId, (newVal) => {
    router.visit(route('dashboard.menus', { menu: newVal }));
});
</script>
<template>
    <fg-card icon="bi-list" title="Select menu" class="overflow-visible">
        <fg-rich-select v-model="selectedMenuId" class="sm" placeholder="Select menu" :options="options" />
    </fg-card>
</template>
