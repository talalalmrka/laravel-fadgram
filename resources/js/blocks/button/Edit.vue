<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import { computed } from 'vue';
import { useOptions } from '@/composables/useOptions';
import {
    EditBlock,
    CollapsePanel,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const {
    buttonSizeOptions,
    buttonColorOptions,
} = useOptions();
const newTab = computed<boolean>({
    get() {
        return atts.value.target === '_blank';
    },
    set(val: boolean) {
        const target = val ? '_blank' : '_self';
        atts.value.target = target;
    },
});
</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Button">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-input v-model="atts.label" label="Label" size="xs" />
                </div>
                <div class="col">
                    <fg-icon-picker v-model="atts.icon" label="Icon" size="xs" />
                </div>
                <div class="col">
                    <fg-input v-model="atts.url" label="url" size="xs" />
                </div>
                <div class="col">
                    <fg-switch v-model="newTab" label="Open in new tab" />
                </div>
            </div>
        </collapse-panel>
        <template #style>
            <div class="grid grid-cols-1 gap-3 p-3">
                <div class="col">
                    <fg-select v-model="atts.color" label="Color" size="xs" :options="buttonColorOptions" />
                </div>
                <div class="col">
                    <fg-select v-model="atts.size" label="Size" size="xs" :options="buttonSizeOptions" />
                </div>
            </div>
        </template>
    </edit-block>
</template>
