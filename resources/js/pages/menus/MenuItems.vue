<script setup lang="ts">
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import draggable from 'vuedraggable'
import MenuItem from './MenuItem.vue'
import { FgLoader, FgIcon, FgAlert } from 'fadgram-vue'
import Status from '@/components/Status.vue'
const page = usePage<{
    props: {
        menu: MenuType;
        items: MenuItemType[];
    }
}>();
const menu = page.props.menu;
const items = page.props.items;
const form = useForm({
    items: items ?? [],
});
const submit = () => {
    form.post(route('dashboard.menus.update.items', { menu: menu.id }), {
        preserveScroll: true,
        onSuccess: () => {
            // You can optionally emit an event or show a toast here
        },
        onError: (errors) => {
            console.log(errors);

        },
    });
}
const localItems = ref<MenuItemType[]>([...items])
function onDragEnd() {
    emit("update:items", localItems);
}
function handleItemUpdate(updatedItem) {
    const updateRecursive = (items) => {
        return items.map(item => {
            if (item.id === updatedItem.id) {
                return { ...updatedItem };
            } else if (item.children && item.children.length) {
                return {
                    ...item,
                    children: updateRecursive(item.children),
                };
            }
            return item;
        });
    };
    localItems = updateRecursive(localItems);
    emit("update:items", localItems); // Ensure it's emitted after update
}
function handleItemRemove(id) {
    const removeRecursive = (items) =>
        items
            .map((item) => {
                if (item.children) {
                    item.children = removeRecursive(item.children);
                }
                return item;
            })
            .filter((item) => item.id !== id);

    localItems = removeRecursive(localItems);
}
function handleTopLevelChange(evt) {
    if (evt.added) {
        const newIndex = evt.added.newIndex;
        const movedItem = localItems[newIndex];
        movedItem.parent_id = null; // No parent at top level
    }

    // Update orders
    localItems.forEach((item, index) => {
        item.order = index;
    });

    emit("update:items", localItems);
}
function save() {
    emit("save", localItems);
    //console.log('save', JSON.stringify(localItems));
    //Livewire.dispatch('save-items', localItems);


}
const formattedJson = computed(() => JSON.stringify(localItems, null, 2))
</script>

<template>
    <h5 class="text-gray-500 dark:text-white flex-space-2">
        <fg-icon icon="bi-list-nested" />
        <span>Structure</span>
    </h5>
    <div class="grid grid-cols-2 gap-4">
        <div class="col">
            <draggable v-if="form.items" v-model="form.items" group="menu-items" item-key="id" handle=".handle"
                class="space-y-2">
                <template #item="{ element }">
                    <menu-item :item="element" :path="`items.${form.items.indexOf(element)}`" />
                </template>
            </draggable>
            <fg-alert v-if="!localItems.length" content="No items found" />
            <div class="mt-2 flex-space-2 justify-between">
                <button @click="submit" type="button" class="btn xs btn-primary w-auto text-nowrap">
                    <fg-icon icon="bi-floppy" />
                    <span>Save changes</span>
                    <fg-loader v-if="form.processing" dots-scale />
                </button>
                <Status name="update_items" />
            </div>
        </div>
        <div class="col max-h-screen overflow-y-auto">
            <pre class="text-sm h-full overflow-y-auto"><code>{{ form.items }}</code></pre>
        </div>
    </div>
</template>
