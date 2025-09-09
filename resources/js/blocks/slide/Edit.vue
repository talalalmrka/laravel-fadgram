<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import {
    EditBlock,
    CollapsePanel,
    SegmentedControl,
    LinkTarget
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const iconPositionOptions = [
    {
        label: 'Start',
        value: 'start',
    },
    {
        label: 'End',
        value: 'end',
    },
]
</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Slide">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-input v-model="atts.title" label="Title" />
                </div>
                <div class="col">
                    <fg-textarea v-model="atts.subtitle" label="Subtitle" />
                </div>
                <div class="col">
                    <image-picker v-model="atts.image" label="Image" />
                </div>
            </div>
        </collapse-panel>
        <collapse-panel title="Action">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-input v-model="atts.actionLabel" label="Label" />
                </div>
                <div class="col">
                    <fg-icon-picker v-model="atts.actionIcon" label="Icon" />
                </div>
                <div class="col">
                    <segmented-control v-model="atts.actionIconPosition" label="Icon position"
                        :options="iconPositionOptions" />
                </div>
                <div class="col">
                    <fg-input v-model="atts.actionUrl" label="Url" />
                </div>
                <div class="col">
                    <link-target v-model="atts.actionTarget" label="Open in new window" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
