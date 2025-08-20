<script setup lang="ts">
import type { BlockType } from '@/types'

const props = defineProps<{
    block: BlockType
}>()
const emit = defineEmits(['edit', 'delete'])

</script>

<template>
    <div class="flex-space-2 px-3 py-1 shadow-xs border rounded bg-white dark:bg-gray-700">
        <div class="flex-1 flex-space-2 cursor-pointer handle" @click="emit('edit', block)">
            <fg-icon :icon="block.icon" />
            <span class="text-sm">{{ block.label }}</span>
        </div>
        <button type="button" @click="emit('delete', block)"
            class="flex items-center justify-center text-red hover:text-red-700">
            <fg-icon icon="bi-trash" />
        </button>
    </div>
</template>
