<script setup lang="ts">
import { BlockType } from '@/types';
import { useAttributes } from '@/composables/useAttributes';
import Dump from '@/components/Dump.vue';
import ServerRender from '../../ServerRender.vue';
const props = defineProps<{
    block: BlockType
}>()
const atts = useAttributes(props.block);
</script>

<template>
    <ServerRender :block="block" />
</template>
