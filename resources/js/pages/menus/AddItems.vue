<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import type { MenuType } from '@/types'
import AddPages from './AddPages.vue'
import AddPosts from './AddPosts.vue'
import AddCategories from './AddCategories.vue'
import AddCustomLink from './AddCustomLink.vue'

const page = usePage<{
    props: {
        menu: MenuType;
    }
}>();
const menu = page.props.menu as MenuType;
</script>

<template>
    <fg-card v-if="menu" icon="fg-plus" title="Add items">
        <fg-accordion storageKey="accordion-add-menu-items" persist>

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
    </fg-card>
</template>