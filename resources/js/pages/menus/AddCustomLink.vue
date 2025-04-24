<script setup lang="ts">
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import type { MenuType } from '@/types'
import Status from '@/components/Status.vue'

import {
    FgInput,
    FgIconPicker,
    FgLoader,
    FgError,
    FgAlert,
} from 'fadgram-vue'

/*const props = defineProps<{
    menu?: MenuType;
    status?: string;
}>();*/
const page = usePage()
const menu = computed<MenuType>(() => page.props.menu as MenuType)
const nameInput = ref<HTMLInputElement | null>(null)
const form = useForm({
    name: '',
    icon: '',
    url: '',
});
const submit = () => {
    form.post(route('dashboard.menus.add.custom', { menu: page.props.menu?.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.log('errors', errors);
        },
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fg-input v-model="form.name" label="Name" :error="form.errors.name" class="sm" placeholder="name" />
            </div>
            <div class="col">
                <fg-icon-picker v-model="form.icon" label="Icon" group-class="sm" placeholder="icon"
                    :error="form.errors.icon" />
            </div>
            <div class="col">
                <fg-input v-model="form.url" label="Url" :error="form.errors.url" class="sm" placeholder="url" />
            </div>
            <div class="col flex-space-2 justify-between">
                <button type="submit" class="btn xs btn-primary w-auto text-nowrap">
                    <span>Add to menu</span>
                    <fg-loader v-if="form.processing" dots-scale />
                </button>
                <Status name="add_custom_link" />
            </div>
        </div>
    </form>
</template>
