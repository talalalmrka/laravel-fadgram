<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Status from '@/components/Status.vue'
import type {
    MenuType,
    CategoryType
} from '@/types'
import {
    FgCheckbox,
    FgAlert,
    FgError,
    FgLoader,
} from 'fadgram-vue'
import CategoriesCheckboxGroup from './CategoriesCheckboxGroup.vue'

const page = usePage()
const menu = computed<MenuType>(() => page.props.menu as MenuType)
const categories = computed<CategoryType[]>(() => page.props.categories as CategoryType[])
const selectAll = ref<boolean>(false);
const form = useForm({
    categories: [] as string[],
});

watch(() => menu, () => {
    form.reset();
});

watch(selectAll, (newVal) => {
    if (newVal) {
        form.categories = categories.value?.map(category => category.id) ?? [];
    } else {
        form.categories = [];
    }
});

const submit = () => {
    form.post(route('dashboard.menus.add.categories', { menu: page.props.menu?.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
        onError: (errors) => {
            console.log('errors', errors)
        },
    });
};

const submitDisabled = computed(() => !form.categories.length);
</script>

<template>
    <form @submit.prevent="submit">
        <categories-checkbox-group :categories="categories" :level="0" class="max-h-40 overflow-y-auto"
            v-model="form.categories" name="categories[]" :key="form.categories.join(',')" />
        <div class="divider my-1"></div>
        <div class="flex-space-2 justify-between">
            <fg-checkbox v-model="selectAll" label="Select all" />
            <button type="submit" class="btn xs btn-primary w-auto text-nowrap" :disabled="submitDisabled">
                <span v-if="!form.processing">Add to menu</span>
                <fg-loader v-if="form.processing" dots-scale />
            </button>
        </div>
        <fg-error :error="form.errors.categories" />
        <Status name="add_categories" />
    </form>
</template>