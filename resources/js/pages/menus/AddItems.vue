<script setup lang="ts">
import { ref, watch, computed, onMounted } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import type {
    OptionType,
    MenuType,
    CategoryType
} from '@/types'

import {
    FgAccordion,
    FgAccordionItem,
    FgAccordionBody,
} from 'fadgram-vue'

import AddPages from './AddPages.vue'
import AddPosts from './AddPosts.vue'
import AddCategories from './AddCategories.vue'
import AddCustomLink from './AddCustomLink.vue'
/*const props = defineProps<{
    menu?: MenuType;
    page_options?: OptionType[];
    add_pages_status?: string;
    post_options?: OptionType[];
    add_posts_status?: string;
    categories?: CategoryType[];
    add_categories_status?: string;
    add_custom_link_status?: string;
}>();*/
const page = usePage()
const menu = computed<MenuType>(() => page.props.menu as MenuType)
</script>

<template>
    <div v-if="menu">
        <h5>Add items</h5>
        <fg-accordion storageKey="accordion-add-menu-items" class="shadow" persist>

            <fg-accordion-item icon="bi-file-earmark-text" title="Pages">
                <fg-accordion-body>
                    <add-pages :key="menu?.value?.id" />
                </fg-accordion-body>
            </fg-accordion-item>


            <fg-accordion-item v-if="menu" icon="bi-newspaper" title="Posts">
                <fg-accordion-body>
                    <add-posts :key="menu?.value?.id" />
                </fg-accordion-body>
            </fg-accordion-item>

            <fg-accordion-item v-if="menu" icon="bi-folder-fill" title="Categories">
                <fg-accordion-body>
                    <add-categories :key="menu?.value?.id" />
                </fg-accordion-body>
            </fg-accordion-item>

            <fg-accordion-item v-if="menu" icon="bi-link-45deg" title="Custom links">
                <fg-accordion-body>
                    <add-custom-link :key="menu?.value?.id" />
                </fg-accordion-body>
            </fg-accordion-item>

        </fg-accordion>

    </div>
</template>
