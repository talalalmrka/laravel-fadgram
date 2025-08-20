<script setup lang="ts">
import { BlockType } from '@/types';

const props = defineProps<{
    block: BlockType
}>()
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <fg-switch v-model="block.fluid" label="Full width" />
        </div>
        <div class="col">
            <fg-input v-model="block.className" label="Css classes" />
        </div>
    </div>
</template>
