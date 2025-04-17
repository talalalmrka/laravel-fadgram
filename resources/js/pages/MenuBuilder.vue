<script setup lang="ts">
import { ref, computed, watch, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import draggable from 'vuedraggable'
import CreateMenu from './CreateMenu.vue'
import SelectMenu from './SelectMenu.vue'
import EditMenu from './EditMenu.vue'
import { Select, Error, Alert } from '@/components'
import type { MenuType, MenuItemType, MenuItemPayload, OptionType } from '../types/types'
import { useToast } from 'primevue/usetoast'
interface Props {
    menus: MenuType[];
    menu?: MenuType;
    menu_position_options?: OptionType[];
    create_status?: string;
    update_status?: string;
    status?: string;
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
        <Alert v-if="status" type="success" size="xs" soft class="mb-4" :content="status" />
        <div class="grid md:grid-cols-2 gap-4">
            <div class="col">
                <CreateMenu :status="create_status" />
            </div>
            <div class="col">
                <select-menu :options="menuOptions" :menuId="menu?.id" :key="menu?.id" />
            </div>
        </div>
        <EditMenu :menu="menu" :positionOptions="menu_position_options" :status="update_status" />
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-4">
            <div class="col md:col-span-2">
                <ul v-for="menu in menus" :key="menu.id">
                    <li>{{ menu.name }}</li>
                </ul>
            </div>
            <div class="col max-h-screen relative">
                <pre class="text-sm h-full overflow-y-auto"><code>{{ menusJson }}</code></pre>
            </div>

        </div>
    </div>

</template>
