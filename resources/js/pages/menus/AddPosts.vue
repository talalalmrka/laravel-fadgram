<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import type { MenuType, PostType } from '@/types'
import Status from '@/components/Status.vue'

const page = usePage<{
    props: {
        menu: MenuType;
        posts: PostType[];
    }
}>();
const menu = page.props.menu as MenuType;
const posts = (page.props.posts ?? []) as PostType[];
const options = computed(() => posts.map((item) => ({ label: item.name, value: item.id })));
const selectAll = ref<boolean>(false);
const form = useForm({
    posts: [] as string[],
});

watch(() => menu, () => {
    form.reset();
});

watch(selectAll, (newVal) => {
    if (newVal) {
        form.posts = options.value?.map(opt => opt.value) ?? [];
    } else {
        form.posts = [];
    }
});

const submit = () => {
    form.post(route('dashboard.menus.add.posts', { menu: menu.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <fg-checkbox v-for="option in options" :key="option.value" v-model="form.posts" :label="option.label"
            name="posts[]" :value="option.value" />
        <div class="divider my-1"></div>
        <div class="flex-space-2 justify-between">
            <fg-checkbox v-model="selectAll" label="Select all" />
            <button type="submit" class="btn xs btn-primary w-auto text-nowrap" :disabled="!form.posts.length">
                <span v-if="!form.processing">Add to menu</span>
                <fg-loader v-if="form.processing" dots-scale />
            </button>
        </div>
        <fg-error :error="form.errors.posts" />
        <Status name="add_posts" />
    </form>
</template>