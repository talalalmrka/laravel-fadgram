<script setup lang="ts">
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import draggable from 'vuedraggable'
import { TransitionExpand } from '@morev/vue-transitions'
import type { MenuType, MenuItemType, PageType, PostType, CategoryType, OptionType } from '@/types'
import {
    FgInput,
    FgSelect,
    FgSwitch,
    FgIconPicker,
    FgIcon,
    FgLoader
} from 'fadgram-vue';

interface Props {
    item: MenuItemType,
    path: string,
}
const props = defineProps<Props>()
const emit = defineEmits(['update', 'remove'])
const page = usePage<{
    props: {
        menu: MenuType;
        pages: PageType[];
        posts: PostType[];
        categories: CategoryType[];
        item_types: OptionType[];
        errors: Record<string, string>;
    }
}>();
const menu = page.props.menu;
const pages = page.props.pages as PageType[];
const posts = page.props.posts as PostType[];
const categories = page.props.categories as CategoryType[];
const typeOptions = page.props.item_types as OptionType[];
const pageOptions = computed(() => pages.map((el: PageType) => ({ label: el.name, value: el.id })));
const postOptions = computed(() => posts.map((el: PostType) => ({ label: el.name, value: el.id })));
const categoryOptions = computed(() => categories.map((el) => ({ label: el.name, value: el.id })));
//const localItem = ref<MenuItemType>({ ...props.item })
const open = ref(false)
function getError(field: string) {
    return page.props.errors?.[`${props.path}.${field}`] || null;
}
function update(updated: MenuItemType) {
    emit('update', updated);
}
function remove(id: string | number) {
    emit('remove', id);
}

const hasErrors = computed(() => {
    return Object.keys(page.props.errors).some(key => key.startsWith(props.path));
});
</script>

<template>
    <div>
        <div :id="path"
            class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm shadow-xs"
            :class="{ 'bg-red/30': hasErrors }">
            <div class="flex items-center rounded-t-lg" :class="{ 'bg-gray-100 dark:bg-gray-600': open }">
                <span class="handle cursor-move flex items-center px-3 py-2 hover:font-semibold">
                    <fg-icon icon="bi-arrows-move" class=" w-4 h-4" />
                </span>
                <button @click="open = !open" type="button" class="flex items-center px-3 py-2 justify-between grow">
                    <div class="grow flex items-center justify-between">
                        <div class="flex-space-2">
                            <span v-if="item.icon" class="flex items-center">
                                <i class="icon" :class="item.icon"></i>
                            </span>
                            <span>{{ item.name }}</span>
                            <span
                                class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">
                                {{ item.order }}
                            </span>
                        </div>
                        <span class="badge xs">{{ item.type }}</span>
                    </div>
                    <span class="flex items-center">
                        <i class="icon bi-chevron-down transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </span>
                </button>
            </div>
            <transition-expand>
                <div v-show="open" class="border-t border-gray-200 dark:border-gray-600 px-3 py-2 rounded-b-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col md:col-span-3">
                            <fg-input label="Name" type="text" v-model="item.name" class="xs"
                                :error="getError('name')" />
                        </div>
                        <div class="col">
                            <fg-icon-picker label="Icon" v-model="item.icon" :error="getError('icon')"
                                groupClass="xs" />
                        </div>
                        <div class="col">
                            <fg-input label="Css class" type="text" v-model="item.class_name" class="xs"
                                :error="getError('class_name')" />
                        </div>
                        <div class="col">
                            <fg-select label="Type" v-model="item.type" class="xs" :error="getError('type')"
                                :options="typeOptions" placeholder="Select type" />
                        </div>
                        <div v-if="item.type === 'custom'" class="col md:col-span-3">
                            <fg-input label="Url" type="text" v-model="item.url" class="xs"
                                placeholder="Item url (url or # or #hash)" :error="getError('url')" />
                        </div>
                        <div v-if="item.type === 'page'" class="col md:col-span-3">
                            <fg-select label="Page" v-model="item.page_id" class="xs" :error="getError('page_id')"
                                placeholder="Select page" :options="pageOptions" />
                        </div>
                        <div v-if="item.type === 'post'" class="col md:col-span-3">
                            <fg-select label="Post" v-model="item.post_id" class="xs" :error="getError('post_id')"
                                placeholder="Select post" :options="postOptions" />
                        </div>
                        <div v-if="item.type === 'category'" class="col md:col-span-3">
                            <fg-select label="Category" v-model="item.category_id" class="xs"
                                :error="getError('category_id')" placeholder="Select category"
                                :options="categoryOptions" />
                        </div>
                        <div class="col">
                            <fg-switch v-model="item.navigate" label="Navigate" info="wire navigate" :value="1"
                                :error="getError('navigate')" />
                        </div>
                        <div class="col">
                            <fg-switch v-model="item.new_tab" label="Open in new tab" :value="1"
                                :error="getError('new_tab')" info="open item in new tab." />
                        </div>
                        <div class="col">
                            <button class="btn xs btn-outline-red" @click="remove(item.id)">
                                <i class="icon bi-trash-fill"></i>
                                <span>Remove</span>
                            </button>
                        </div>
                    </div>
                </div>
            </transition-expand>
        </div>
        <div class="ms-4 mt-2">
            <draggable v-model="item.children" group="menu-items" item-key="id" handle=".handle" class="space-y-2">
                <template #item="{ element }">
                    <menu-item :item="element" :path="`${path}.children.${item.children!.indexOf(element)}`"
                        @remove="remove(element.id)" />
                </template>
            </draggable>
        </div>
    </div>
</template>
