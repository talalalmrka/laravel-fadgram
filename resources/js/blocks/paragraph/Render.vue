<script setup lang="ts">
import { Block } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
import { computed, ref } from 'vue';
const props = defineProps<{
    block: Block
    activeBlock?: Block
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
