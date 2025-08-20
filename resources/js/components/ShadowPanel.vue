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
    shadowSizeOptions,
    shadowColorOptions,
} = useOptions();
</script>

<template>
    <CollapsePanel v-if="features.margin" title="Shadow">
        <div class="grid grid-cols-2 gap-3">
            <div class="col">
                <fg-select v-model="atts.shadowSize" label="Size" :options="shadowSizeOptions" class="xs" />
            </div>
            <div class="col">
                <fg-select v-model="atts.shadowColor" label="Color" :options="shadowColorOptions" class="xs" />
            </div>
        </div>
    </CollapsePanel>
</template>
