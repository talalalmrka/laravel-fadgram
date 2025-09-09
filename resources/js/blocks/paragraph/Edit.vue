<script setup lang="ts">
import CollapsePanel from '@/components/CollapsePanel.vue';
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import {
    EditBlock,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Paragraph">
            <div class="grid grid-cols- gap-4">
                <div class="col">
                    <fg-textarea v-model="atts.content" label="Content" />
                </div>
            </div>
        </collapse-panel>
    </edit-block>
</template>
