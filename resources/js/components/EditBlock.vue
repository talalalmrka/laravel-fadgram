<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { useBlockFeatures } from '@/composables/useBlocks';
import { useOptions } from '@/composables/useOptions';
import {
    Block,
    Tab,
} from '@/types';
import {
    CollapsePanel,
    ImagePicker,
    SegmentedControl,
    TabPanel,
    SpacingControl,
    BorderControl,
    ShadowControl,
    BreakpointTabsControl,
    BreakpointSelectControl,
} from '@/components'
import { computed, defineAsyncComponent, watch } from 'vue';
import { isFlex } from '@/helpers';
const props = defineProps<{
    block: Block
}>()
const features = useBlockFeatures(props.block.type);
const atts = computed(() => useAttributes(props.block).value)
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
    marginOptions,
    paddingOptions,
    displayOptions,
    flexDirectionOptions,
    alignItemsOptions,
    justifyContentOptions,
    gapOptions,
    insetOptions,
    zIndexOptions,
    positionOptions,
} = useOptions()

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
const flex = computed(() => isFlex(atts))
const initialTab = computed({
    get() {
        const localTab = localStorage.getItem('initialTab');
        return localTab && tabs.map((t) => t.name).includes(localTab) ? localTab : null;
    },
    set(val: string | null) {
        localStorage.setItem('initialTab', val ?? '')
    },
});

const tabUpdated = (name: string) => {
    initialTab.value = name;
}
const editComponent = defineAsyncComponent(() =>
    import(`@builder/blocks/${props.block?.type}/Edit.vue`)
)
watch(() => props.block.id, () => {
    // atts = useAttributes(props.block)
})
</script>

<template>
    <tab-panel :tabs="tabs" :initial-tab="initialTab" @update:active-tab="tabUpdated"
        head-class="sticky top-0 bg-body-bg dark:bg-body-bg-dark">
        <template #content>
            <slot :key="block.id" />
        </template>
        <template #style>
            <slot name="style"></slot>
            <collapse-panel v-if="features.typography" title="Typography">
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
                        <segmented-control v-model="atts.textAlign" label="Text align" :options="textAlignOptions"
                            class="sm" />
                    </div>
                </div>
            </collapse-panel>
            <collapse-panel v-if="features.bgColor || features.bgImage" title="Background">
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
            </collapse-panel>
        </template>
        <template #advanced>
            <slot name="advanced"></slot>
            <collapse-panel title="Wrapper styles">
                <div class="grid grid-cols-1 gap-3">

                    <div v-if="features.margin" class="col">
                        <spacing-control v-model="atts.margin" label="Margin" :options="marginOptions"
                            :key="`margin-${block.id}`" />
                        <hr />
                    </div>
                    <div v-if="features.padding" class="col">
                        <spacing-control v-model="atts.padding" label="Padding" :options="paddingOptions"
                            :key="`padding-${block.id}`" />
                        <hr />
                    </div>
                    <div v-if="features.border" class="col">
                        <border-control v-model="atts" label="Border" />
                        <hr />
                    </div>
                    <div v-if="features.shadow" class="col">
                        <shadow-control v-model="atts" label="Shadow" :key="`shadow-${block.id}`" />
                        <hr />
                    </div>
                    <div v-if="features.position" class="col">
                        <breakpoint-tabs-control v-model="atts.position" label="Position" :options="positionOptions"
                            :key="`position-${block.id}`" />
                        <!-- <position-control v-model="atts.position" label="Position" :key="`position-${block.id}`" /> -->
                        <hr />
                    </div>
                    <div v-if="features.display" class="grid grid-cols-1 gap-3">
                        <div class="col">
                            <breakpoint-tabs-control v-model="atts.display" label="Display" :options="displayOptions"
                                :key="`display-${block.id}`" />
                            <hr />
                        </div>
                        <div v-if="flex" class="col">
                            <div class="grid grid-cols-1 gap-3">
                                <div class="col">
                                    <breakpoint-tabs-control v-model="atts.flexDirection" label="Flex direction"
                                        :options="flexDirectionOptions" :key="`flex-direction-${block.id}`" />
                                    <hr />
                                </div>
                                <div class="col">
                                    <breakpoint-tabs-control v-model="atts.alignItems" label="Align items"
                                        :options="alignItemsOptions" :key="`align-items-${block.id}`" />
                                    <hr />
                                </div>
                                <div class="col">
                                    <breakpoint-tabs-control v-model="atts.justifyContent" label="Justify content"
                                        :options="justifyContentOptions" :key="`justify-content-${block.id}`" />
                                    <hr />
                                </div>
                                <div class="col">
                                    <breakpoint-select-control v-model="atts.gap" label="Gap" :options="gapOptions"
                                        :key="`gap-${block.id}`" />
                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="features.inset" class="col">
                        <spacing-control v-model="atts.inset" label="Inset" :options="insetOptions"
                            :key="`inset-${block.id}`" />
                    </div>
                    <div v-if="features.zIndex" class="col">
                        <fg-select v-model="atts.zIndex" label="zIndex" :options="zIndexOptions" />
                    </div>
                </div>
            </collapse-panel>
            <collapse-panel v-if="features.htmlAnchor || features.className || features.style" title="Advanced">
                <div class="grid grid-cols-1 gap-3 p-3">
                    <div class="col" v-if="features.htmlAnchor">
                        <fg-input v-model="atts.htmlAnchor" label="Html anchor" size="sm" />
                    </div>
                    <div class="col" v-if="features.className">
                        <fg-textarea v-model="atts.className" label="Css classes" size="sm" />
                    </div>
                    <div class="col" v-if="features.style">
                        <fg-textarea v-model="atts.style" label="Css style" size="sm" />
                    </div>
                </div>
            </collapse-panel>
        </template>
    </tab-panel>
</template>
