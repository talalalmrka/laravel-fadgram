<script setup lang="ts">
import BorderPanel from '@/components/BorderPanel.vue';
import CollapsePanel from '@/components/CollapsePanel.vue';
import ImagePicker from '@/components/ImagePicker.vue';
import MarginsPanel from '@/components/MarginsPanel.vue';
import SegmentedControl from '@/components/SegmentedControl.vue';
import ShadowPanel from '@/components/ShadowPanel.vue';
import TabPanel from '@/components/TabPanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { useBlockFeatures } from '@/composables/useBlocks';
import { useOptions } from '@/composables/useOptions';
import { BlockType } from '@/types';
import { Tab } from '@/types/tab';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
const {
    textColorOptions,
    fontSizeOptions,
    fontWeightOptions,
    fontStyleOptions,
    textTransformOptions,
    textAlignOptions,
    bgColorOptions,
    bgSizeOptions,
    bgPositionOptions,
    bgAttachmentOptions,
} = useOptions()
const features = useBlockFeatures(props.block.type);
const tabs: Tab[] = [
    {
        name: 'content',
        icon: props.block.icon,
        title: props.block.label ?? 'Content',
    },
    {
        name: 'style',
        icon: 'bi-palette',
        title: 'Style'
    },
    {
        name: 'advanced',
        icon: 'bi-gear-wide-connected',
        title: 'Advanced'
    },
];
</script>

<template>
    <TabPanel :tabs="tabs">
        <template #content>
            <slot />
        </template>
        <template #style>
            <slot name="style"></slot>
            <CollapsePanel v-if="features.typography" title="Typography">
                <div class="grid grid-cols-1 gap-3">
                    <div class="col">
                        <fg-select v-model="atts.textColor" label="Text color" :options="textColorOptions" class="sm" />
                    </div>
                    <div class="col">
                        <fg-select v-model="atts.fontSize" label="Font size" :options="fontSizeOptions" class="sm" />
                    </div>
                    <div class="col">
                        <fg-select v-model="atts.fontWeight" label="Font weight" :options="fontWeightOptions"
                            class="sm" />
                    </div>
                    <div class="col">
                        <fg-select v-model="atts.fontStyle" label="Font style" :options="fontStyleOptions" class="sm" />
                    </div>
                    <div class="col">
                        <fg-select v-model="atts.textTransform" label="Text transform" :options="textTransformOptions"
                            class="sm" />
                    </div>
                    <div class="col">
                        <SegmentedControl v-model="atts.textAlign" label="Text align" :options="textAlignOptions"
                            class="sm" />
                    </div>
                </div>
            </CollapsePanel>
            <CollapsePanel v-if="features.bgColor || features.bgImage" title="Background">
                <div class="grid grid-cols-1 gap-3">
                    <div class="col" v-if="features.bgColor">
                        <fg-select v-model="atts.bgColor" label="Background color" :options="bgColorOptions"
                            class="sm" />
                    </div>
                    <div class="col" v-if="features.bgImage">
                        <ImagePicker v-model="atts.bgImage" />
                    </div>
                    <div class="col" v-if="features.bgImage">
                        <fg-select v-model="atts.bgSize" label="Background size" :options="bgSizeOptions" class="sm" />
                    </div>
                    <div class="col" v-if="features.bgImage">
                        <fg-select v-model="atts.bgPosition" label="Background position" :options="bgPositionOptions"
                            class="sm" />
                    </div>
                    <div class="col" v-if="features.bgImage">
                        <fg-select v-model="atts.bgAttachment" label="Background attachment"
                            :options="bgAttachmentOptions" class="sm" />
                    </div>
                </div>
            </CollapsePanel>
        </template>
        <template #advanced>
            <slot name="advanced"></slot>
            <MarginsPanel v-if="features.margin || features.padding" :block="block" />
            <BorderPanel v-if="features.border" :block="block" />
            <ShadowPanel v-if="features.shadow" :block="block" />
            <CollapsePanel v-if="features.htmlAnchor || features.className || features.style" title="Advanced">
                <div class="grid grid-cols-1 gap-3 p-3">
                    <div class="col" v-if="features.htmlAnchor">
                        <fg-input v-model="atts.htmlAnchor" label="Html anchor" size="sm" />
                    </div>
                    <div class="col" v-if="features.className">
                        <fg-input v-model="atts.className" label="Css classes" size="sm" />
                    </div>
                    <div class="col" v-if="features.style">
                        <fg-textarea v-model="atts.style" label="Css style" size="sm" />
                    </div>
                </div>
            </CollapsePanel>
        </template>
    </TabPanel>
</template>
