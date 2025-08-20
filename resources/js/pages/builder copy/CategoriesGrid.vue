<script setup lang="ts">
import { BlockType } from '@/types';
import { ref } from 'vue';
import SelectChoices from '@/components/SelectChoices.vue';
import { useUserOptions } from '@/composables/useUsers';
import { useSortOptions } from '@/composables/useSortOptions';

const props = defineProps<{
    block: BlockType
}>()
const block = ref(props.block)
const userOptions = useUserOptions();
const sortOptions = useSortOptions();
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fg-switch v-model="block.show_title" label="Show title" />
        </div>
        <div class="col">
            <fg-input type="text" v-model="block.title" size="sm" label="Title" placeholder="Block title" />
        </div>
        <div class="col">
            <SelectChoices v-model="block.users" label="By user" :options="userOptions" placeholder="Select user"
                :multiple="true" key="users" />
        </div>
        <div class="col">
            <fg-input type="number" v-model="block.limit" size="sm" label="Limit" />
        </div>
        <div class="col">
            <fg-select v-model="block.sort" size="sm" label="Sort" :options="sortOptions" />
        </div>
        <div class="col">
            <fg-input v-model="block.className" size="sm" label="Css classes" />
        </div>
    </div>
</template>
