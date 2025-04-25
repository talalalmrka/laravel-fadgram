<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { FgIcon, FgError, FgLoader } from 'fadgram-vue'
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
    <div class="card">
        <div class="card-header text-primary">
            <div class="card-title flex-space-2">
                <i class="icon bi-plus"></i>
                <span>Create menu</span>
            </div>
        </div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="input-group xs w-full">
                    <input ref="nameInput" type="text" v-model="form.name" name="name" class="form-control"
                        :class="{ 'error': form.errors.name }" @input="form.clearErrors('name')"
                        placeholder="Enter menu name">
                    <button type="submit" class="btn btn-primary w-[100px]" :disabled="form.processing">
                        <fg-icon icon="fg-plus" />
                        <span v-if="!form.processing">Create</span>
                        <fg-loader v-if="form.processing" dots-scale />
                    </button>
                </div>
                <fg-error :error="form.errors.name" />
                <Status name="create_menu" class="mt-2" />
            </form>
        </div>
    </div>
</template>
