<script setup lang="ts">
import EditorCollapse from '@/components/EditorCollapse.vue';
import ImagePicker from '@/components/ImagePicker.vue';
import SegmentedControl from '@/components/SegmentedControl.vue';
import SelectChoices from '@/components/SelectChoices.vue';
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
    categoryOptions,
    tagOptions,
    userOptions,
    sortOptions,
} = useOptions()

</script>

<template>
    <EditorCollapse title="Content">
        <div class="grid grid-cols-1 gap-3">
            <div class="col">
                <fg-switch v-model="atts.show_title" label="Show title" />
            </div>
            <div class="col">
                <fg-input v-model="atts.title" label="Title" />
            </div>
            <div class="col">
                <SelectChoices v-model="atts.categories" label="Category" :options="categoryOptions"
                    placeholder="Category" :multiple="true" key="categories" />
            </div>
            <div class="col">
                <SelectChoices v-model="block.tags" label="Tag" :options="tagOptions" placeholder="Tag" :multiple="true"
                    key="tags" />
            </div>
            <div class="col">
                <SelectChoices v-model="block.users" label="By user" :options="userOptions" placeholder="Select user"
                    :multiple="true" key="users" />
            </div>
            <div class="col">
                <fg-input type="number" v-model="block.limit" size="sm" label="Limit" />
            </div>
            <div class="col">
                <fg-select v-model="block.sort" size="sm" label="Sort" :options="sortOptions" />
            </div>
            <div class="col">
                <fg-input v-model="block.className" size="sm" label="Css classes" />
            </div>
        </div>
    </EditorCollapse>
    <EditorCollapse title="Typography">
        <div class="grid grid-cols-1 gap-3">
            <div class="col">
                <fg-select v-model="atts.color" label="Text color" :options="textColorOptions" class="sm" />
            </div>
            <div class="col">
                <fg-select v-model="atts.fontSize" label="Font size" :options="fontSizeOptions" class="sm" />
            </div>
            <div class="col">
                <fg-select v-model="atts.fontWeight" label="Font weight" :options="fontWeightOptions" class="sm" />
            </div>
            <div class="col">
                <fg-select v-model="atts.fontStyle" label="Font style" :options="fontStyleOptions" class="sm" />
            </div>
            <div class="col">
                <fg-select v-model="atts.textTransform" label="Text transform" :options="textTransformOptions"
                    class="sm" />
            </div>
            <div class="col">
                <SegmentedControl v-model="atts.textAlign" label="Text align" :options="textAlignOptions" class="sm" />
            </div>
        </div>
    </EditorCollapse>
    <EditorCollapse title="Background">
        <div class="grid grid-cols-1 gap-3">
            <div class="col">
                <fg-select v-model="atts.bgColor" label="Background color" :options="bgColorOptions" class="sm" />
            </div>
            <div class="col">
                <ImagePicker v-model="atts.bgImage" label="Background image" />
            </div>
            <div class="col">
                <fg-select v-model="atts.bgSize" label="Background size" :options="bgSizeOptions" class="sm" />
            </div>
            <div class="col">
                <fg-select v-model="atts.bgPosition" label="Background position" :options="bgPositionOptions"
                    class="sm" />
            </div>
            <div class="col">
                <fg-select v-model="atts.bgAttachment" label="Background attachment" :options="bgAttachmentOptions"
                    class="sm" />
            </div>
        </div>
    </EditorCollapse>
    <EditorCollapse title="Advanced">
        <div class="grid grid-cols-1 gap-3">
            <div class="col">
                <fg-input v-model="atts.className" label="Css classes" size="sm" />
            </div>
            <div class="col">
                <fg-textarea v-model="atts.style" label="Css style" size="sm" />
            </div>
        </div>
    </EditorCollapse>
</template>
