<script setup lang="ts">
import { ref, watch } from 'vue'
import draggable from 'vuedraggable'
import type { MenuItemType, MenuItemPayload } from '@/types'
import {
    FgInput,
    FgSelect,
    //FgSwitch,
    FgIconPicker,
} from 'fadgram-vue';

import FgSwitch from '@/components/FgSwitch.vue';

interface Props {
    item: MenuItemType
}

const props = defineProps<Props>()
const emit = defineEmits(['update', 'remove'])

const localItem = ref<MenuItemType>({ ...props.item })
const open = ref(false)
const isEditing = ref(false)

const typeOptions = [
    { label: 'Custom Link', value: 'custom' },
    { label: 'Page', value: 'page' },
    { label: 'Category', value: 'category' },
    { label: 'Post', value: 'post' }
]

watch(() => props.item, (newVal) => {
    localItem.value = { ...newVal }
}, { deep: true });
function deepCopy(obj) {
    return JSON.parse(JSON.stringify(obj))
}
function handleUpdate() {
    console.log('handleUpdate');

    emit('update', { ...localItem });
}

function handleChildUpdate(updatedChild) {
    console.log('handleChildUpdate');

    const index = localItem.children.findIndex(c => c.id === updatedChild.id)
    if (index >= 0) {
        localItem.children.splice(index, 1, updatedChild)
    } else {
        localItem.children.push(updatedChild)
    }
    handleUpdate()
}

function handleRemove() {
    emit('remove', localItem.id)
}

function checkMove(evt) {
    const depth = getDepth(evt.draggedContext.element)
    return depth <= 3
}

function getDepth(item, current = 1) {
    if (!item.children || item.children.length === 0) return current
    return Math.max(...item.children.map(c => getDepth(c, current + 1)))
}

function handleDragChange(evt) {
    if (evt.added) {
        const newIndex = evt.added.newIndex;
        const movedItem = localItem.children[newIndex];
        movedItem.parent_id = localItem.id; // Set parent to current item
    }

    // Reorder children based on their index
    localItem.children.forEach((child, index) => {
        child.order = index;
    });

    handleUpdate(); // Emit updated item upward
}
</script>

<template>
    <div>
        <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm">
            <div class="flex justify-between items-center space-x-2 px-3 py-2">
                <div class="flex-space-2 items-center grow justify-between">
                    <div class="flex-space-2">
                        <span class="handle cursor-move flex items-center">
                            <i class="icon bi-arrows-move w-4 h-4"></i>
                        </span>
                        <span v-if="item.icon" class="flex items-center">
                            <i class="icon" :class="item.icon"></i>
                        </span>
                        <span>{{ item.name }}</span>
                        <span
                            class="text-xs flex items-center rounded-full inset-shadow-sm inset-shadow-gray-200 px-2">{{
                                item.order }}</span>
                    </div>
                    <span class="badge xs">{{ item.type }}</span>
                </div>
                <button @click="open = !open" class="flex items-center">
                    <i class="icon bi-chevron-down transition-transform duration-200"
                        :class="{ 'rotate-180': open }"></i>
                </button>
            </div>
            <div v-if="open" class="border-t px-3 py-2">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col md:col-span-3">
                        <fg-input label="Name" :id="'item.' + localItem.id + '.name'" type="text" v-model="item.name"
                            class="xs" :error="null" />
                    </div>
                    <div class="col">
                        <fg-icon-picker label="Icon" :id="'item.' + localItem.id + '.icon'" v-model="item.icon"
                            groupClass="xs" :error="null" />
                    </div>
                    <div class="col">
                        <fg-input label="Css class" :id="'item.' + localItem.id + '.class_name'" type="text"
                            v-model="item.class_name" class="xs" :error="null" />
                    </div>
                    <div class="col">
                        <fg-select label="Type" :id="'item.' + localItem.id + '.type'" v-model="item.type" class="xs"
                            :error="null" :options="typeOptions" />
                    </div>
                    <div v-if="localItem.type === 'custom'" class="col md:col-span-3">
                        <fg-input label="Url" :id="'item.' + localItem.id + '.url'" type="text" v-model="item.url"
                            class="xs" :error="null" />
                    </div>
                    <div class="col">
                        <fg-switch v-model="item.navigate" label="Navigate" info="wire navigate" :value="1" />
                        {{ item.navigate }}
                    </div>
                    <div class="col">
                        <fg-switch v-model="item.new_tab" label="Open in new tab" :value="1" />
                    </div>
                    <div class="col">
                        <button class="btn xs btn-outline-red" @click="handleRemove">
                            <i class="icon bi-trash-fill"></i>
                            <span>Remove</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="ms-4 mt-2">
            <draggable v-model="item.children" group="menu-items" item-key="id" handle=".handle" class="space-y-2"
                @change="handleDragChange" @end="handleUpdate" :move="checkMove">
                <template #item="{ element }">
                    <menu-item :item="element" @update="handleChildUpdate" @remove="$emit('remove', $event)" />
                </template>
            </draggable>
        </div>
    </div>
</template>
