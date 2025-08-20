<script setup lang="ts">
import { useColorOptions } from '@/composables/useColor';
import { useSizeOptions } from '@/composables/useSize';
import { BlockType } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    block: BlockType
}>()

const colorOptions = useColorOptions();
const sizeOptions = useSizeOptions();
const newTab = computed<boolean>({
    get: () => props.block.target === '_blank',
    set: (val: boolean) => {
        props.block.target = val ? '_blank' : '_self';
    },
});
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fg-input v-model="block.label" label="Label" size="sm" />
        </div>
        <div class="col">
            <fg-icon-picker v-model="block.icon" label="Icon" size="sm" />
        </div>
        <div class="col">
            <fg-input v-model="block.url" label="Url" autocomplete="url" size="sm" />
        </div>
        <div class="col">
            <fg-switch v-model="newTab" label="Open in new window" />
        </div>
        <div class="col">
            <fg-select v-model="block.color" label="Color" :options="colorOptions" class="sm" />
        </div>
        <div class="col">
            <fg-switch v-model="block.outline" label="Outline" />
        </div>
        <div class="col">
            <fg-switch v-model="block.gradient" label="Gradient" />
        </div>
        <div class="col">
            <fg-switch v-model="block.pill" label="Rounded" />
        </div>
        <div class="col">
            <fg-select v-model="block.size" label="Size" :options="sizeOptions" class="sm" />
        </div>
        <div class="col">
            <fg-input v-model="block.className" label="Css classes" size="sm" />
        </div>
    </div>
</template>
