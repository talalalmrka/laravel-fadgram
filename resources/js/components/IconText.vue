<script setup lang="ts">
const props = defineProps<{
    icon?: string;
    label?: string;
    iconClass?: string;
    labelClass?: string;
}>()
</script>

<template>
    <div v-bind="$attrs" :class="{ 'flex-space-2': icon && label }">
        <fg-icon v-if="icon" :icon="icon" :class="iconClass" />
        <span v-if="label" :class="labelClass">{{ label }}</span>
    </div>
</template>
