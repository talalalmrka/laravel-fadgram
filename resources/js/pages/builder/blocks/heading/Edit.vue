<script setup lang="ts">
import CollapsePanel from '@/components/CollapsePanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { BlockType } from '@/types';
import EditorPanel from '../../EditorPanel.vue';
import { useOptions } from '@/composables/useOptions';
const props = defineProps<{
    block: BlockType
}>()
const { headingTagOptions } = useOptions();
const atts = useAttributes(props.block);
</script>
<template>
    <EditorPanel :block="block">
        <CollapsePanel title="Container">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-select v-model="atts.tag" label="Html tag" :options="headingTagOptions" />
                </div>
                <div class="col">
                    <fg-textarea v-model="atts.title" label="Title" />
                </div>
                <div class="col">
                    <fg-icon-picker v-model="atts.icon" label="Icon" />
                </div>
            </div>
        </CollapsePanel>
    </EditorPanel>
</template>
