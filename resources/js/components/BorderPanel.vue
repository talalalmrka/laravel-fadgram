<script setup lang="ts">
import CollapsePanel from './CollapsePanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { useOptions } from '@/composables/useOptions';
import { BlockType } from '@/types';
import { useBlockFeatures } from '@/composables/useBlocks';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
const features = useBlockFeatures(props.block.type);
const {
    borderSizeOptions,
    borderColorOptions,
    borderStyleOptions,
    borderRadiusOptions,
} = useOptions();
</script>

<template>
    <CollapsePanel v-if="features.margin" title="Border">
        <div class="grid grid-cols-4 gap-3">
            <div class="col">
                <fg-select v-model="atts.borderSize" label="Size" :options="borderSizeOptions" class="xs" />
            </div>
            <div class="col">
                <fg-select v-model="atts.borderStyle" label="Style" :options="borderStyleOptions" class="xs" />
            </div>
            <div class="col">
                <fg-select v-model="atts.borderColor" label="Color" :options="borderColorOptions" class="xs" />
            </div>
            <div class="col">
                <fg-select v-model="atts.borderRadius" label="Radius" :options="borderRadiusOptions" class="xs" />
            </div>

        </div>
    </CollapsePanel>
</template>
