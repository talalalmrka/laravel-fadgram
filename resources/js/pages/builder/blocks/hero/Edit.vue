<script setup lang="ts">
import CollapsePanel from '@/components/CollapsePanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { BlockType } from '@/types';
import EditorPanel from '../../EditorPanel.vue';
import { useOptions } from '@/composables/useOptions';
import { computed } from 'vue';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
const {
    themeOptions,
} = useOptions();
</script>

<template>
    <EditorPanel :block="block">
        <CollapsePanel title="Container">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">
                    <fg-select v-model="atts.theme" label="Theme" :options="themeOptions" class="sm" />
                </div>
                <div class="col">
                    <fg-switch v-model="atts.fullscreen" label="Fullscreen" />
                </div>
                <div class="col">
                    <fg-input v-model="atts.title" label="Title" class="xs" />
                </div>
                <div class="col">
                    <fg-input v-model="atts.subtitle" label="Subtitle" class="xs" />
                </div>
                <div class="col">
                    <fg-textarea v-model="atts.text" label="Text" />
                </div>
            </div>
        </CollapsePanel>
    </EditorPanel>
</template>
