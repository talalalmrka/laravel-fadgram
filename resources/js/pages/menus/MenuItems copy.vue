<script setup lang="ts">
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3';
import draggable from 'vuedraggable'
import MenuItem from './MenuItem.vue'
import { FgLoader, FgIcon, FgAlert } from 'fadgram-vue';
const page = usePage<{
    props: {
        menu: MenuType;
        items: MenuItemType[];
    }
}>();
const menu = page.props.menu;
const items = page.props.items;
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
            <draggable v-if="localItems" v-model="localItems" group="menu-items" item-key="id" handle=".handle"
                class="space-y-2" @change="handleTopLevelChange" @end="onDragEnd">
                <template #item="{ element }">
                    <menu-item :item="element" @update="handleItemUpdate" @remove="handleItemRemove" />
                </template>
            </draggable>
            <fg-alert v-if="!localItems.length" content="No items found" />
        </div>
        <div class="col max-h-screen overflow-y-auto">
            <pre class="text-sm h-full overflow-y-auto"><code>{{ localItems }}</code></pre>
        </div>
    </div>
</template>
