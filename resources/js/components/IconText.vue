<script setup lang="ts">
const props = withDefaults(defineProps<{
    tag?: string;
    icon?: string;
    label?: string;
    iconClass?: string;
    labelClass?: string;
}>(), {
    tag: 'div'
})
</script>

<template>
    <component :is="tag ?? 'div'" v-bind="$attrs" :class="{ 'flex-space-2': icon && label }">
        <fg-icon v-if="icon" :icon="icon" :class="iconClass" />
        <span v-if="label" :class="labelClass">{{ label }}</span>
    </component>
</template>
