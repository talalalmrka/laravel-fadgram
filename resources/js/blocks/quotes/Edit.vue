<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import { useOptions } from '@/composables/useOptions';
import {
    EditBlock,
    CollapsePanel,
    SelectChoices,
    SegmentedControl,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const {
    categoryOptions,
    tagOptions,
    userOptions,
    authorOptions,
    sortOptions,
    layoutOptions,
} = useOptions();

</script>

<template>
    <edit-block :block="block">
        <collapse-panel title="Quotes">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-switch v-model="atts.show_title" label="Show title" />
                </div>
                <div class="col">
                    <fg-input v-model="atts.title" label="Title" size="sm" />
                </div>
                <div class="col">
                    <segmented-control v-model="atts.layout" label="Layout" size="sm" :options="layoutOptions" />
                </div>
                <div class="col">
                    <select-choices v-model="atts.categories" label="Category" :options="categoryOptions"
                        placeholder="Category" :multiple="true" key="categories" />
                </div>
                <div class="col">
                    <select-choices v-model="atts.tags" label="Tag" :options="tagOptions" placeholder="Tag"
                        :multiple="true" key="tags" />
                </div>
                <div class="col">
                    <select-choices v-model="atts.users" label="By user" :options="userOptions"
                        placeholder="Select user" :multiple="true" key="users" />
                </div>
                <div class="col">
                    <select-choices v-model="atts.authors" label="By author" :options="authorOptions"
                        placeholder="Select author" :multiple="true" key="users" />
                </div>
                <div class="col">
                    <fg-input type="number" v-model="atts.limit" size="sm" label="Limit" />
                </div>
                <div class="col">
                    <fg-select v-model="atts.sort" size="sm" label="Sort" :options="sortOptions" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
