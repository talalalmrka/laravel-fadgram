<script setup lang="ts">
import { BlockType } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
import { computed, ref } from 'vue';
const props = defineProps<{
    block: BlockType
    activeBlock?: BlockType
}>()
const atts = useAttributes(props.block);
const content = computed(() => atts.value.content && atts.value.content !== '' ? atts.value.content : 'Write paragraph here')
const editing = ref(false);
</script>

<template>
    <p v-bind="$attrs">
        {{ content }}
    </p>
</template>
