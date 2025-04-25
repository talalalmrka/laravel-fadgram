<script setup lang="ts">
import { computed } from 'vue'
import CreateMenu from './CreateMenu.vue'
import SelectMenu from './SelectMenu.vue'
import EditMenu from './EditMenu.vue'
import AddItems from './AddItems.vue'
import { FgAlert, FgIcon } from 'fadgram-vue'
import { Status } from '@/components'
import MenuItems from './MenuItems.vue';
defineProps<{
    menu?: MenuType;
    items?: MenuItemType[];
}>();
</script>

<template>
    <div>
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
                <menu-items :key="`menu-items-${items.length}`" />
            </div>
        </div>
    </div>
</template>