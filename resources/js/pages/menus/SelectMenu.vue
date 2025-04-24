<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { FgSelect, FgRichSelect } from "fadgram-vue";
import { OptionType } from '@/types/types';

const props = defineProps<{
    menuId?: number;
    options?: OptionType[];
}>();
const selectedMenuId = ref<number | null>(props.menuId ?? null);
watch(selectedMenuId, (newVal) => {
    router.get(route('dashboard.menus.builder', { menu: newVal }));
});
</script>
<template>
    <div class="card overflow-visible">
        <div class="card-header text-primary">
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
