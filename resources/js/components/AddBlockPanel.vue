<script setup lang="ts">
import { BlockPicker } from '@/components';
import { useBlockIcon, useBlockLabel } from '@/composables/useBlocks';
import { Block } from '@/types'
import { computed } from 'vue';

const props = defineProps<{
    show: boolean
    activeBlock?: Block
}>()

const label = useBlockLabel(props.activeBlock?.type)
const icon = useBlockIcon(props.activeBlock?.type)
</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 start-0 w-80 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
        :class="{ '-translate-x-full': !show, 'translate-x-0': show }">
        <div class="flex-space-2 px-3 py-2 top-0 border-b bg-gray-50 dark:bg-gray-700">
            <div class="flex-1 flex-space-2 font-bold ">
                <fg-icon icon="bi-plus-lg" />
                <span>Add block</span>
            </div>
            <fg-badge v-if="label || icon" :label="label" :icon="icon" class="text-nowrap truncate" />
            <button type="button" @click="$emit('close')">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
        <block-picker :active-block="activeBlock" />
    </div>
</template>
