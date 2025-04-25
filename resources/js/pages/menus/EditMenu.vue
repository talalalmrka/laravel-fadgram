<script setup lang="ts">
import { ref, watch } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { MenuType, OptionType } from '@/types'
import { FgInput, FgSelect, FgAlert, FgIcon, FgLoader } from 'fadgram-vue'
import Status from '@/components/Status.vue'
const page = usePage<{
    props: {
        menu: MenuType;
        positions: OptionType[];
    }
}>();
const menu = page.props.menu;
const positions = page.props.positions;
const nameInput = ref<{ inputRef: HTMLInputElement } | null>(null)
const classNameInput = ref<{ inputRef: HTMLInputElement } | null>(null)

const form = useForm({
    name: menu.name ?? '',
    position: menu.position ?? '',
    class_name: menu.class_name ?? '',
})
const deleteForm = useForm({
    menu: menu.id ?? '',
})

// Whenever `menu` changes, reset the form to its new values:
watch(
    menu,
    (newMenu) => {
        form.reset({
            name: newMenu.name ?? '',
            position: newMenu.position ?? '',
            class_name: newMenu.class_name ?? '',
        })

        deleteForm.reset({
            menu: newMenu.id ?? '',
        })
    },
    { immediate: true }
)

const submit = () => {
    form.post(route('dashboard.menus.update', { menu: menu.id }), {
        preserveScroll: true,
        onSuccess: () => {
            // You can optionally emit an event or show a toast here
        },
        onError: (errors) => {
            if (errors.name && nameInput.value) {
                nameInput.value.inputRef.focus()
            }
            if (errors.class_name && classNameInput.value) {
                classNameInput.value.inputRef.focus()
            }
        },
    });
}
const deleteMenu = () => {
    deleteForm.delete(route('dashboard.menus.delete', { menu: menu.value.id }), {
        preserveScroll: true,
    });
}
</script>

<template>
    <div v-if="menu" class="card mt-4">
        <div class="card-header text-primary">
            <div class="card-title flex-space-2">
                <fg-icon icon="bi-gear-wide-connected" />
                <span>Settings ({{ menu.name }})</span>
            </div>
        </div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fg-input ref="nameInput" v-model="form.name" name="name" class="sm" :error="form.errors.name"
                            label="Name" placeholder="Menu name" @input="form.clearErrors('name')" />
                    </div>
                    <div class="col">
                        <fg-select v-model="form.position" name="position" class="sm" :error="form.errors.position"
                            label="Position" :options="positions" placeholder="None" />
                    </div>
                    <div class="col">
                        <fg-input ref="classNameInput" v-model="form.class_name" name="class_name" class="sm"
                            :error="form.errors.class_name" label="CSS Class" placeholder="e.g. my-custom-menu"
                            @input="form.clearErrors('class_name')" />
                    </div>
                    <div class="col flex-space-2 justify-between">
                        <div class="flex-space-2 grow">
                            <button type="submit" class="btn btn-primary sm" :disabled="form.processing">
                                <fg-icon icon="bi-floppy" />
                                <span>Save</span>
                                <fg-loader v-if="form.processing" dots-scale />
                            </button>
                            <Status name="update_menu" />
                        </div>
                        <button type="button" @click.prevent="deleteMenu" class="btn btn-outline-red sm">
                            <i class="icon bi-trash-fill"></i>
                            <span>Delete</span>
                            <fg-loader v-if="deleteForm.processing" dots-scale />
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
