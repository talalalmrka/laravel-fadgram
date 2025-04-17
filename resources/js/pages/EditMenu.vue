<script setup lang="ts">
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Input, Select, Alert } from '@/components'
const props = defineProps<{
    menu?: MenuType;
    positionOptions?: Array<{ value: string | null; label: string }>;
    status?: string;
}>();
const nameInput = ref<{ inputElement: HTMLInputElement }>();
const positionInput = ref<HTMLInputElement | null>(null);
const classNameInput = ref<{ inputElement: HTMLInputElement }>();

const form = useForm({
    name: props.menu?.name ?? '',
    position: props.menu?.position ?? '',
    class_name: props.menu?.class_name ?? '',
});

watch(() => props.menu, (newVal) => {
    form.reset();
    form.name = newVal?.name;
    form.position = newVal?.position;
    form.class_name = newVal?.class_name;
});

const submit = () => {
    form.post(route('dashboard.menus.update', { menu: props.menu.id }), {
        preserveScroll: true,
        onSuccess: () => {
            /*toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Menu updated successfully',
                life: 3000
            });*/
        },
        onError: (errors) => {
            if (errors.name && nameInput.value) {
                nameInput.value?.inputElement.focus();
            }
            if (errors.position && positionInput.value) {
                positionInput.value.focus();
            }
            if (errors.class_name && classNameInput.value) {
                classNameInput.value?.inputElement.focus();
            }
        },
    });
};
</script>

<template>
    <div v-if="menu" class="card mt-4">
        <div class="card-header">
            <div class="card-title flex-space-2">
                <i class="icon bi-gear-wide-connected"></i>
                <span>Settings ({{ menu.name }})</span>
            </div>
        </div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <Input ref="nameInput" v-model="form.name" name="name" class="sm" :error="form.errors.name"
                            label="Name" placeholder="Menu name" @input="form.clearErrors('name')" />
                    </div>
                    <div class="col">
                        <Select ref="positionInput" v-model="form.position" name="position" class="sm"
                            :error="form.errors.position" label="Position" :options="positionOptions"
                            placeholder="Select position" />
                    </div>
                    <div class="col">
                        <Input ref="classNameInput" v-model="form.class_name" name="class_name" class="sm"
                            :error="form.errors.class_name" label="Css class" placeholder="Css class names"
                            @input="form.clearErrors('class_name')" />
                    </div>
                    <div class="col flex-space-2 justify-between">
                        <div class="flex-space-2 grow">
                            <button type="submit" class="btn btn-primary sm" :disabled="form.processing">
                                <i class="icon bi-floppy"></i>
                                <span v-if="!form.processing">Save</span>
                                <i v-if="form.processing" class="icon fg-loader"></i>
                            </button>
                            <Alert v-if="status" type="success" size="xs" outline class="p-0 border-0 bg-transparent"
                                :content="status" />
                        </div>
                        <a :href="route('dashboard.menus.delete', { menu: menu })" class="btn btn-outline-red sm">
                            <i class="icon bi-trash-fill"></i>
                            <span>Delete</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>
