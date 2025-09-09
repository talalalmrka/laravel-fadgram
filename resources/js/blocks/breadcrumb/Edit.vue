<script setup lang="ts">
import { useAttributes } from '@/composables/useAttributes';
import { Block } from '@/types';
import { computed } from 'vue';
import { useOptions } from '@/composables/useOptions';
import {
    EditBlock,
    CollapsePanel,
} from '@/components'
const props = defineProps<{
    block: Block
}>()
const atts = useAttributes(props.block);
const {
    buttonSizeOptions,
    buttonColorOptions,
} = useOptions();
const newTab = computed<boolean>({
    get() {
        return atts.value.target === '_blank';
    },
    set(val: boolean) {
        const target = val ? '_blank' : '_self';
        atts.value.target = target;
    },
});
</script>
<template>
    <edit-block :block="block">
        <collapse-panel title="Breadcrumb">
            <div class="grid grid-cols-1 gap-3">
                <div class="col">

                </div>

            </div>
        </collapse-panel>
    </edit-block>
</template>
