<script setup lang="ts">
import { Block } from '@/types';
import { useBlockIcon, useBlockLabel } from '@/composables/useBlocks';
import { defineAsyncComponent, ref, watch } from 'vue';
import { useAttributes } from '@/composables/useAttributes';
import { EditBlock } from '@/components'
import EventBus from '@/types/event-bus';
const props = defineProps<{
    show: boolean
    block?: Block
}>()
const icon = ref<string | undefined>(undefined)
const label = ref<string | undefined>(undefined)
const atts = ref<Record<string, any>>({})
const editComponent = defineAsyncComponent(() =>
    import(`@/blocks/${props.block?.type}/Edit.vue`)
)

watch(
    () => props.block,
    (block) => {
        if (block) {
            icon.value = useBlockIcon(block.type)
            label.value = useBlockLabel(block.type)
            atts.value = useAttributes(block)
        } else {
            icon.value = undefined
            label.value = undefined
            atts.value = {}
        }

    },
    { deep: true, immediate: true }
);
</script>

<template>
    <div class="fixed top-0 pt-11 bottom-0 end-0 w-72 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
        :class="{ 'translate-x-full': !show, 'translate-x-0': show }">
        <div class="border-b bg-gray-50 dark:bg-gray-700">
            <div class="flex-space-2 px-3 py-2 font-semibold text-sm">
                <div class="flex-1 flex-space-2 overflow-hidden">
                    <fg-icon :icon="icon" />
                    <span>{{ label }}</span>
                </div>
                <button v-if="block" type="button" title="Reset defaults" class="link hover:link-underline flex-space-1"
                    @click="EventBus.emit('resetActiveBlock')">
                    <fg-icon icon="bi-arrow-repeat" />
                </button>
                <button type="button" title="Close" @click="EventBus.emit('closeEditor')">
                    <fg-icon icon="bi-x-lg" />
                </button>
            </div>
        </div>

        <div v-if="block" class="flex-1 overflow-y-auto">
            <component :is="editComponent" :block="block" :key="`edit-component-${block.id}`" />
        </div>
    </div>
</template>
