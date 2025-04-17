<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { Select } from "@/components";

const props = defineProps<{
    menuId?: number | null;
    options?: Array<{ value: number; label: string }>;
}>();
const selectedMenuId = ref<number | null>(props.menuId ?? null);
watch(selectedMenuId, (newVal) => {
    router.get(route('dashboard.menus.builder', { menu: newVal }));
});
</script>
<template>
    <div class="card">
        <div class="card-header text-primary">
            <div class="card-title flex-space-2">
                <i class="icon bi-plus"></i>
                <span>Select menu</span>
            </div>
        </div>
        <div class="card-body">
            <Select v-model="selectedMenuId" class="sm" placeholder="Select menu" :options="options" />
        </div>
    </div>
</template>
