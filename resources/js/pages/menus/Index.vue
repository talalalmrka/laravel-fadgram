<script setup lang="ts">
import { useForm } from '@inertiajs/inertia-vue3'
import { MenuType, MenuItemType } from '@/types'
import CreateMenu from './CreateMenu.vue'
import SelectMenu from './SelectMenu.vue'
import EditMenu from './EditMenu.vue'
import AddItems from './AddItems.vue'
import { Status } from '@/components'
import MenuStructure from './MenuStructure.vue';
import { route } from 'ziggy-js'
defineProps<{
    menu?: MenuType;
    items?: MenuItemType[];
}>();
const form = useForm({});
const resetDefaults = () => {
    form.post(route('dashboard.menus.reset'), {
        preserveScroll: true,
    });

};
</script>
<template>
    <div>
        <div class="mb-4 flex-space-2 justify-between">
            <button type="button" @click="resetDefaults" class="btn btn btn-red btn-xs pill">
                <fg-icon icon="bi-arrow-counterclockwise" />
                <span>Reset defaults</span>
                <fg-loader v-show="form.processing" dots-scale />
            </button>
            <Status name="reset_defaults" />
        </div>

        <Status name="status" />

        <div class="grid md:grid-cols-2 gap-4">
            <div class="col">
                <create-menu :key="`create-menu-${menu?.id || 'default'}`" />
            </div>
            <div class="col">
                <select-menu :key="`select-menu-${menu?.id || 'default'}`" />
            </div>
        </div>
        <fg-alert v-if="!menu" soft class="mt-4" content="No menu selected" />
        <edit-menu v-if="menu" :key="`edit-menu-${menu?.id || 'default'}`" />
        <div v-if="menu" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="col">
                <add-items :key="`add-items-${menu?.id || 'default'}`" />
            </div>
            <div class="col md:col-span-2">
                <menu-structure :key="`menu-items-${items?.length ?? '0'}`" />
            </div>
        </div>
    </div>
</template>