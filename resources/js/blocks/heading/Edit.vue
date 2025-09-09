<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import { useOptions } from '@/composables/useOptions';
import {
    EditBlock,
    CollapsePanel
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const { headingTagOptions } = useOptions();
const atts = useAttributes(props.block);
</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Heading">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-select v-model="atts.tag" label="Html tag" :options="headingTagOptions" />
                </div>
                <div class="col">
                    <fg-textarea v-model="atts.title" label="Title" />
                </div>
                <div class="col">
                    <fg-icon-picker v-model="atts.icon" label="Icon" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
