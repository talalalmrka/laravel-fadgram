<script setup lang="ts">
import { usePage, useForm } from '@inertiajs/vue3'
import { computed, watchEffect, watch } from 'vue'
import draggable from 'vuedraggable'
import MenuItem from './MenuItem.vue'
import { FgLoader, FgIcon, FgAlert } from 'fadgram-vue'
import Status from '@/components/Status.vue'
import type { MenuType, MenuItemType } from '@/types'
import { route } from 'ziggy-js'
interface PageProps {
    menu: MenuType;
    items: MenuItemType[];
    errors: Record<string, string | string[]>;
    flash?: Record<string, string>;
}
const page = usePage<{ props: PageProps }>();
const menu = computed(() => page.props.menu)
const items = computed(() => {
    const ensureChildren = (list: MenuItemType[]): MenuItemType[] =>
        list.map(item => ({
            ...item,
            children: item.children ? ensureChildren(item.children) : []
        }))
    return ensureChildren(Array.isArray(page.props.items) ? page.props.items : [])
})
const form = useForm({
    items: items.value as any
});
const hasItems = computed(() => Array.isArray(form.items) && (form.items as any[]).length > 0)

// Recursive removal with typed args
function removeItem(id: string | number) {
    const filterOut = (list: MenuItemType[]): MenuItemType[] =>
        list
            .filter(item => item.id !== id)
            .map(item => ({
                ...item,
                children: item.children ? filterOut(item.children) : []
            }))

    form.items = filterOut(form.items as MenuItemType[])
}

// Handle child updates
function updateItem(index: number, updated: MenuItemType) {
    const items = form.items as MenuItemType[]
    items[index] = updated
    form.items = items
}

// Submit
function submit() {
    form.post(route('dashboard.menus.items.update', { menu: page.props.menu.id }), {
        preserveScroll: true,
    });
}


</script>

<template>
    <div class="card">
        <div class="card-header flex-space-2 justify-between">
            <div class="card-title flex-space-2 text-primary">
                <fg-icon icon="bi-list-nested" />
                <span>Structure</span>
            </div>
            <button type="button" class="text-sm link" @click="form.items = page.props.items">Reset</button>
        </div>
        <div class="card-body">
            <draggable v-if="hasItems" v-model="form.items" group="menu-items" item-key="id" handle=".handle"
                class="space-y-2">
                <template #item="{ element, index }">
                    <menu-item :item="element" :path="`items.${index}`" @remove="removeItem" />
                </template>
            </draggable>
            <fg-alert v-else soft content="No items found!" />
        </div>
        <div class="card-footer flex-space-2 justify-between">
            <button @click="submit" type="button" class="btn sm btn-primary w-auto text-nowrap">
                <fg-icon icon="bi-floppy" />
                <span>Save changes</span>
                <fg-loader v-if="form.processing" dots-scale />
            </button>
            <Status name="update_items" class="text-sm" />
        </div>
    </div>
</template>
