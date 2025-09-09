<script setup lang="ts">
import CollapsePanel from '@/components/CollapsePanel.vue';
import ImagePicker from '@/components/ImagePicker.vue';
import SegmentedControl from '@/components/SegmentedControl.vue';
import TabPanel from '@/components/TabPanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { useOptions } from '@/composables/useOptions';
import { Block } from '@/types';
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const {
    headingTagOptions,
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

</script>

<template>
    <TabPanel :tabs="[
        { name: 'content', title: 'Content' },
        { name: 'style', title: 'Style' },
        { name: 'advanced', title: 'Advanced' },
    ]">
        <template #content>
            <collapse-panel title="Container">
                <div class="grid grid-cols-1 gap-3">
                    <div class="col">
                        <fg-select v-model="atts.tag" label="Html tag" :options="headingTagOptions" />
                    </div>
                    <div class="col">
                        <fg-input v-model="atts.title" label="Title" />
                    </div>
                    <div class="col">
                        <fg-icon-picker v-model="atts.icon" label="Icon" />
                    </div>
                </div>
            </collapse-panel></template>
        <template #style>
            <collapse-panel title="Typography">
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
            </collapse-panel><collapse-panel title="Background">
                <div class="grid grid-cols-1 gap-3">
                    <div class="col">
                        <fg-select v-model="atts.bgColor" label="Background color" :options="bgColorOptions"
                            class="sm" />
                    </div>
                </div>
            </collapse-panel></template>
        <template #advanced>
            <collapse-panel title="Advanced">
                <div class="grid grid-cols-1 gap-3">
                    <div class="col">
                        <fg-input v-model="atts.className" label="Css classes" size="sm" />
                    </div>
                    <div class="col">
                        <fg-textarea v-model="atts.style" label="Css style" size="sm" />
                    </div>
                </div>
            </collapse-panel></template>
    </TabPanel>
</template>
