<script setup lang="ts">
import CollapsePanel from '@/components/CollapsePanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { BlockType } from '@/types';
import EditorPanel from '../../EditorPanel.vue';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
</script>
<template>
    <EditorPanel :block="block">
        <CollapsePanel title="Container">
            <div class="grid grid-cols- gap-4">
                <div class="col">
                    <fg-textarea v-model="atts.content" label="Content" />
                </div>
            </div>
        </CollapsePanel>
    </EditorPanel>
</template>
