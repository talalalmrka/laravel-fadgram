<script setup lang="ts">
import { BlockType } from '@/types';
import { useBlockIcon, useBlockLabel } from '@/composables/useBlocks';
import { defineAsyncComponent } from 'vue';
const props = defineProps<{
    show: boolean
    block?: BlockType
}>()
const emit = defineEmits(['edit', 'close'])
const icon = useBlockIcon(props.block?.type)
const label = useBlockLabel(props.block?.type)
const editComponent = defineAsyncComponent(() =>
    import(`@builder/blocks/${props.block?.type}/Edit.vue`)
)
</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 end-0 w-72 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
        :class="{ 'translate-x-full': !show, 'translate-x-0': show }">
        <div class="flex-space-2 px-3 py-2 top-0 border-b bg-gray-50 dark:bg-gray-700">
            <div class="flex-1 flex-space-2 font-bold">
                <fg-icon :icon="icon" />
                <span>{{ label }}</span>
            </div>
            <button type="button" @click="emit('close')">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
        <div v-if="block" class="flex-1 overflow-y-auto">
            <component :is="editComponent" :block="block" />
        </div>
    </div>
</template>
