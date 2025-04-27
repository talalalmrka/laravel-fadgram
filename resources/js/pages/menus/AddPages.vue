<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import type { MenuType, PageType } from '@/types'
import Status from '@/components/Status.vue'
import {
    FgCheckbox,
    FgError,
    FgLoader,
} from 'fadgram-vue';
import { route } from 'ziggy-js';

const page = usePage<{
    props: {
        menu: MenuType;
        pages: PageType[];
    }
}>();
const menu = page.props.menu;
const pages = page.props.pages ?? [];
const options = computed(() => pages.map((item) => ({ label: item.name, value: item.id })));
const selectAll = ref<boolean>(false);
const form = useForm({
    pages: [] as string[],
});

watch(() => menu, () => {
    form.reset();
});

watch(selectAll, (newVal) => {
    if (newVal) {
        form.pages = options.value?.map(opt => opt.value) ?? [];
    } else {
        form.pages = [];
    }
});

const submit = () => {
    form.post(route('dashboard.menus.add.pages', { menu: menu.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <fg-checkbox v-for="option in options" :key="option.value" v-model="form.pages" :label="option.label"
            name="pages[]" :value="option.value" />
        <div class="divider my-1"></div>
        <div class="flex-space-2 justify-between">
            <fg-checkbox v-model="selectAll" label="Select all" />
            <button type="submit" class="btn xs btn-primary w-auto text-nowrap" :disabled="!form.pages.length">
                <span v-if="!form.processing">Add to menu</span>
                <fg-loader v-if="form.processing" dots-scale />
            </button>
        </div>
        <fg-error :error="form.errors.pages" />
        <Status name="add_pages" />
    </form>
</template>