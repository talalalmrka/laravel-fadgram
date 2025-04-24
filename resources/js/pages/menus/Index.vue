<script setup lang="ts">
import { computed } from 'vue'
import CreateMenu from './CreateMenu.vue'
import SelectMenu from './SelectMenu.vue'
import EditMenu from './EditMenu.vue'
import AddItems from './AddItems.vue'
import type {
    MenuType,
    MenuItemType,
    OptionType,
    CategoryType
} from '@/types'
import { FgAlert, FgIcon } from 'fadgram-vue'
interface Props {
    menus: MenuType[];
    categories: CategoryType[];
    menu?: MenuType;
    items?: MenuItemType[];
    menu_position_options?: OptionType[];
    create_status?: string;
    update_status?: string;
    status?: string;
    page_options?: OptionType[];
    add_pages_status?: string;
    post_options?: OptionType[];
    add_posts_status?: string;
    category_options?: OptionType[];
    add_categories_status?: string;
    menu_item_type_options?: OptionType[];
    add_custom_link_status?: string;
}
const props = defineProps<Props>();
const menuOptions = computed(() => {
    return props.menus.map(m => {
        return { label: m.name, value: m.id };
    });
})
const menusJson = computed(() =>
    JSON.stringify(props.menus, null, 2)
)
</script>

<template>
    <div class="">
        <fg-alert v-if="status" type="success" size="xs" soft class="mb-4" :content="status" />
        <div class="grid md:grid-cols-2 gap-4">
            <div class="col">
                <create-menu :key="menu?.id" />
            </div>
            <div class="col">
                <select-menu :options="menuOptions" :menuId="menu?.id" :key="menu?.id" />
            </div>
        </div>
        <fg-alert v-if="!menu" soft class="mt-4" content="No menu selected" />
        <edit-menu v-if="menu" :key="menu?.id" />
        <div v-if="menu" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="col">
                <add-items :menu="menu" :page_options="page_options" :add_pages_status="add_pages_status"
                    :post_options="post_options" :add_posts_status="add_posts_status" :categories="categories"
                    :add_categories_status="add_categories_status" :add_custom_link_status="add_custom_link_status" />
            </div>
            <div class="col md:col-span-2">
                <h5>Structure</h5>
                <ul class="list-group shadow">
                    <li v-for="item in items" :key="item.id" class="list-group-item">
                        <fg-icon :icon="item.icon" />
                        {{ item.name }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
