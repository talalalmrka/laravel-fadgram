<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { FgRichSelect, FgLoader } from "fadgram-vue";
import { MenuType } from '@/types/types';
import { route } from 'ziggy-js';

const page = usePage<{ props: { menus: MenuType[]; menu: MenuType } }>();
const menus = page.props.menus ?? [];
const menu = page.props.menu;
const options = computed(() => menus.map((item) => ({ label: item.name, value: item.id })));
const selectedMenuId = ref<number | null>(menu?.id ?? null);

watch(selectedMenuId, (newVal) => {
    router.visit(route('dashboard.menus', { menu: newVal }));
});
</script>
<template>
    <div class="card overflow-visible">
        <div class="card-header text-primary rounded-t-lg">
            <div class="card-title flex-space-2">
                <i class="icon bi-plus"></i>
                <span>Select menu</span>
            </div>
        </div>
        <div class="card-body">
            <fg-rich-select v-model="selectedMenuId" class="sm" placeholder="Select menu" :options="options" />
        </div>
    </div>
</template>
