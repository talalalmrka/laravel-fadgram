<script setup lang="ts">
import TabPanel from './TabPanel.vue';
import CollapsePanel from './CollapsePanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { useOptions } from '@/composables/useOptions';
import { BlockType } from '@/types';
import { computed } from 'vue';
import { useBlockFeatures } from '@/composables/useBlocks';
import { data_get } from '@/helpers';
import { Tab } from '@/types/tab';
import Dump from './Dump.vue';
import _ from 'lodash';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
const features = useBlockFeatures(props.block.type);
const {
    breakpoints,
    sides,
    marginOptions,
    paddingOptions
} = useOptions();
const margin = computed<Record<string, any>>({
    get() {
        return atts.value.margin ?? {};
    },
    set(val) {
        atts.value.margin = val;
    },
});
const padding = computed<Record<string, any>>({
    get() {
        return atts.value.padding ?? {};
    },
    set(val) {
        atts.value.padding = val;
    },
});
const tabs: Tab[] = breakpoints.map((b) => ({
    name: b,
    title: b,
}));
const sideOptions = sides.map((s) => ({
    label: s.charAt(0).toUpperCase() + s.slice(1),
    name: s,
    value: s.charAt(0),
}))
</script>

<template>
    <CollapsePanel v-if="features.margin" title="Margin" panel-class="!p-0">
        <TabPanel :tabs="tabs">
            <template v-for="tab in tabs" #[tab.name]>
                <div class="grid grid-cols-4 gap-3 p-2">
                    <div v-for="side in sideOptions" class="col">
                        <fg-select v-model="margin[tab.name][side.name]" :label="side.label"
                            :options="data_get(marginOptions, `${tab.name}.${side.name}`, [])" class="xs" />
                    </div>
                </div>
            </template>
        </TabPanel>
    </CollapsePanel>
    <CollapsePanel v-if="features.padding" title="Padding" panel-class="!p-0">
        <TabPanel :tabs="tabs">
            <template v-for="tab in tabs" #[tab.name]>
                <div class="grid grid-cols-4 gap-3 p-2">
                    <div v-for="side in sideOptions" class="col">
                        <fg-select v-model="padding[tab.name][side.name]" :label="side.label"
                            :options="data_get(paddingOptions, `${tab.name}.${side.name}`, [])" class="xs" />
                    </div>
                </div>
            </template>
        </TabPanel>
    </CollapsePanel>
</template>
