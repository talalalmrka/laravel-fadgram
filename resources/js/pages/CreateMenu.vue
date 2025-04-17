<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';
import { Alert, Error } from "@/components";
defineProps<{
    status?: string;
}>();
const nameInput = ref<HTMLInputElement | null>(null);
const form = useForm({
    name: '',
});
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
                nameInput.value.focus();
            }
        },
    });

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
                <div class="input-group sm w-full">
                    <input ref="nameInput" type="text" v-model="form.name" name="name" class="form-control"
                        :class="{ 'error': form.errors.name }" @input="form.clearErrors('name')"
                        placeholder="Enter menu name">
                    <button type="submit" class="btn btn-primary w-[87px]" :disabled="form.processing">
                        <i class="icon fg-plus"></i>
                        <span v-if="!form.processing">Create</span>
                        <i v-if="form.processing" class="icon fg-loader"></i>
                    </button>
                </div>
                <Alert v-if="status" type="success" size="xs" soft class="mt-2" :content="status" />
                <Error :error="form.errors.name" />
            </form>
        </div>
    </div>
</template>
