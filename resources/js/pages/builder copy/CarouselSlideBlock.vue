<script setup lang="ts">
import FgCollapse from '@/components/FgCollapse.vue';
import ImagePicker from '@/components/ImagePicker.vue';
import LinkTarget from '@/components/LinkTarget.vue';
import SegmentedControl from '@/components/SegmentedControl.vue';
import { BlockType } from '@/types';
import { computed, ref } from 'vue';

const props = defineProps<{
    block: BlockType
}>()
const size = ref('');

const iconPositionOptions = [
    {
        label: 'Start',
        value: 'start',
    },
    {
        label: 'End',
        value: 'end',
    },
];
const sizeOptions = [
    {
        label: 'xxs',
        value: 'xxs',
    },
    {
        label: 'xs',
        value: 'xs',
    },
    {
        label: 'sm',
        value: 'sm',
    },
    {
        label: 'lg',
        value: 'lg',
    },
    {
        label: 'xl',
        value: 'xl',
    },
]
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fg-input v-model="block.title" label="Title" size="sm" />
        </div>
        <div class="col">
            <fg-input v-model="block.subtitle" label="Subtitle" size="sm" />
        </div>
        <div class="col">
            <ImagePicker v-model="block.image" label="Image" />
        </div>
        <div class="col">
            <FgCollapse :open="true" title="Action button" icon="bi-cursor">
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fg-input v-model="block.actionLabel" label="Label" size="sm" />

                    </div>
                    <div class="col">
                        <fg-icon-picker v-model="block.actionIcon" label="Icon" />
                    </div>
                    <div class="col">
                        <SegmentedControl v-model="block.actionIconPosition" label="Icon position"
                            :options="iconPositionOptions" />

                    </div>
                    <div class="col">
                        <fg-input v-model="block.actionUrl" label="Url" size="sm" />

                    </div>
                    <div class="col">
                        <LinkTarget v-model="block.actionTarget" label="Open in new window" />
                    </div>
                    <div class="col">
                        <fg-input v-model="block.actionClassName" label="Css classes" size="sm" />
                    </div>
                </div>
            </FgCollapse>
        </div>
        <div class="col">
            <fg-input v-model="block.className" label="Css classes" size="sm" />
        </div>
    </div>
</template>
