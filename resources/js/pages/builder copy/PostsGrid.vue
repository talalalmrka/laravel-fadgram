<script setup lang="ts">
import { BlockType } from '@/types';
import { ref } from 'vue';
import { useCategoryOptions } from '@/composables/useCategories';
import SelectChoices from '@/components/SelectChoices.vue';
import { useTagOptions } from '@/composables/useTags';
import { useUserOptions } from '@/composables/useUsers';
import { useSortOptions } from '@/composables/useSortOptions';

const props = defineProps<{
    block: BlockType
}>()
const block = ref(props.block)
const categoryOptions = useCategoryOptions();
const tagOptions = useTagOptions();
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
            <SelectChoices v-model="block.categories" label="Category" :options="categoryOptions" placeholder="Category"
                :multiple="true" key="categories" />
        </div>
        <div class="col">
            <SelectChoices v-model="block.tags" label="Tag" :options="tagOptions" placeholder="Tag" :multiple="true"
                key="tags" />
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
