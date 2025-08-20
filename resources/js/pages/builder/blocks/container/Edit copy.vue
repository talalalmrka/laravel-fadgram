<script setup lang="ts">
import CollapsePanel from '@/components/CollapsePanel.vue';
import ImagePicker from '@/components/ImagePicker.vue';
import MarginsPanel from '@/components/MarginsPanel.vue';
import SegmentedControl from '@/components/SegmentedControl.vue';
import TabPanel from '@/components/TabPanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { useOptions } from '@/composables/useOptions';
import { BlockType } from '@/types';
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

</script>

<template>
    <TabPanel :tabs="[
        {
            name: 'content',
            title: 'Content'
        },
        {
            name: 'style',
            title: 'Style'
        },
        {
            name: 'advanced',
            title: 'Advanced'
        },
    ]">
        <template #content>
            <CollapsePanel title="Container">
                <div class="grid grid-cols-1 gap-3">
                    <div class="col">
                        <fg-switch v-model="atts.fullWidth" label="Full width" />
                    </div>
                </div>
            </CollapsePanel>
        </template>
        <template #style>
            <CollapsePanel title="Typography">
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
            <CollapsePanel title="Background">
                <div class="grid grid-cols-1 gap-3">
                    <div class="col">
                        <fg-select v-model="atts.bgColor" label="Background color" :options="bgColorOptions"
                            class="sm" />
                    </div>
                    <div class="col">
                        <ImagePicker v-model="atts.bgImage" />
                    </div>
                    <div class="col">
                        <fg-select v-model="atts.bgSize" label="Background size" :options="bgSizeOptions" class="sm" />
                    </div>
                    <div class="col">
                        <fg-select v-model="atts.bgPosition" label="Background position" :options="bgPositionOptions"
                            class="sm" />
                    </div>
                    <div class="col">
                        <fg-select v-model="atts.bgAttachment" label="Background attachment"
                            :options="bgAttachmentOptions" class="sm" />
                    </div>
                </div>
            </CollapsePanel>
        </template>
        <template #advanced>
            <MarginsPanel :block="block" />
            {{ atts.margin }}
            <CollapsePanel title="Advanced">
                <div class="grid grid-cols-1 gap-3 p-3">
                    <div class="col">
                        <fg-input v-model="atts.className" label="Css classes" size="sm" />
                    </div>
                    <div class="col">
                        <fg-textarea v-model="atts.style" label="Css style" size="sm" />
                    </div>
                </div>
            </CollapsePanel>
        </template>
    </TabPanel>
</template>
