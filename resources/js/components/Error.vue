<script setup lang="ts">
defineProps<{
    error?: string
}>()
</script>
<template>
    <div v-if="error" class="mt-2 text-xs text-red-600 dark:text-red-500">{{ error }}</div>
</template>
