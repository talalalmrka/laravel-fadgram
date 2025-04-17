<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    id?: string
    info?: string
}>()
const idAttr = computed(() => {
    return `${props.id}-help`;
})
</script>
<template>
    <div v-if="info" :id="idAttr" class="form-info">{{ info }}</div>
</template>
