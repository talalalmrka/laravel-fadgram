<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import { useOptions } from '@/composables/useOptions';
import {
    EditBlock,
    CollapsePanel,
    SegmentedControl,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const {
    themeOptions
} = useOptions()
const transitionOptions = [
    {
        label: 'Slide',
        value: 'slide',
    },
    {
        label: 'Fade',
        value: 'fade',
    },
]
</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Carousel">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <segmented-control v-model="atts.theme" label="Theme" :options="themeOptions" />
                </div>
                <div class="col">
                    <fg-switch v-model="atts.autoplay" label="Autoplay" />
                </div>
                <div class="col">
                    <fg-switch v-model="atts.controls" label="Controls" />
                </div>
                <div class="col">
                    <fg-switch v-model="atts.indicators" label="Indicators" />
                </div>
                <div class="col">
                    <segmented-control v-model="atts.transition" label="Transition" :options="transitionOptions" />
                </div>
                <div class="col">
                    <fg-input type="number" v-model="atts.duration" label="Duration" />
                </div>
                <div class="col">
                    <fg-input type="number" v-model="atts.interval" label="Interval" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
