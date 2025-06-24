<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js';
import Status from '@/components/Status.vue'

const nameInput = ref<HTMLInputElement | null>(null);
const form = useForm({
    name: '',
})
const submit = () => {
    form.post(route('dashboard.menus.store'), {
        preserveScroll: true,
        onSuccess: () => {
            if (!form.hasErrors) {
                form.reset();
            }
        },
        onError: (errors) => {
            if (errors.name && nameInput.value instanceof HTMLInputElement) {
                nameInput.value.focus()
            }
        },
    })

};
</script>
<template>
    <fg-card icon="fg-plus" title="Create menu">
        <form @submit.prevent="submit">
            <div class="input-group sm w-full">
                <input ref="nameInput" type="text" v-model="form.name" name="name" class="form-control flex-1"
                    :class="{ 'error': form.errors.name }" @input="form.clearErrors('name')"
                    placeholder="Enter menu name">
                <button type="submit" class="btn btn-primary text-nowrap flex-space-2 w-[100px]"
                    :disabled="form.processing">
                    <fg-icon icon="fg-plus" />
                    <span v-show="true">Create</span>
                    <fg-loader v-show="form.processing" dots-scale />
                </button>
            </div>
            <fg-error :error="form.errors.name" />
            <Status name="create_menu" class="mt-2" />
        </form>
    </fg-card>
</template>
