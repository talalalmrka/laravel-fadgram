<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import type { MenuType } from '@/types'

import {
    FgAccordion,
    FgAccordionItem,
    FgAccordionBody,
    FgIcon,
} from 'fadgram-vue'

import AddPages from './AddPages.vue'
import AddPosts from './AddPosts.vue'
import AddCategories from './AddCategories.vue'
import AddCustomLink from './AddCustomLink.vue'

const page = usePage<{
    props: {
        menu: MenuType;
    }
}>();
const menu = page.props.menu;
</script>

<template>
    <div v-if="menu">
        <h5 class="text-gray-500 dark:text-white flex-space-2">
            <fg-icon icon="fg-plus" />
            <span>Add items</span>
        </h5>
        <fg-accordion storageKey="accordion-add-menu-items" class="shadow" persist>

            <fg-accordion-item icon="bi-file-earmark-text" title="Pages">
                <fg-accordion-body>
                    <add-pages :key="menu?.id" />
                </fg-accordion-body>
            </fg-accordion-item>

            <fg-accordion-item v-if="menu" icon="bi-newspaper" title="Posts">
                <fg-accordion-body>
                    <add-posts :key="menu?.id" />
                </fg-accordion-body>
            </fg-accordion-item>

            <fg-accordion-item v-if="menu" icon="bi-folder-fill" title="Categories">
                <fg-accordion-body>
                    <add-categories :key="menu?.id" />
                </fg-accordion-body>
            </fg-accordion-item>

            <fg-accordion-item v-if="menu" icon="bi-link-45deg" title="Custom links">
                <fg-accordion-body>
                    <add-custom-link :key="menu?.id" />
                </fg-accordion-body>
            </fg-accordion-item>

        </fg-accordion>
    </div>

</template>