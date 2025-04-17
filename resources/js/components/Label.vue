<script setup lang="ts">
import { computed, useAttrs } from 'vue'

const props = defineProps<{
    'for'?: string
    label?: string
    icon?: string
    error?: string
}>()

const hasLabel = computed(() => !!props.label || !!props.icon)
const attrs = useAttrs()
</script>

<template>
    <label v-if="hasLabel" :for="props.for" class="form-label flex-space-2" :class="{ error: error }" v-bind="attrs">
        <i v-if="icon" class="icon" :class="icon"></i>
        <span v-if="label">{{ label }}</span>
    </label>
</template>
