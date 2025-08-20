<script setup lang="ts">
import { BlockType } from '@/types';
import { ref } from 'vue';
const props = defineProps<{
    block: BlockType
}>()
const block = ref(props.block)
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <jodit-editor v-model="block.content" />
            <fg-textarea v-model="block.content" label="Content" />
        </div>
        <div class="col">
            <fg-input v-model="block.className" size="sm" label="Css classes" />
        </div>
    </div>
</template>
