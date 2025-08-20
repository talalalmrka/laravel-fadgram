<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useError } from '@/composables/useError';
import { useFlash } from '@/composables/useFlash';
const props = withDefaults(defineProps<{
    name: string;
    class?: string;
}>(), {
    name: 'status'
});
const errorMessage = useError(props.name)
const flashMessage = useFlash(props.name)
</script>
<template>
    <fg-alert v-if="flashMessage" v-bind="$attrs" type="success" outline size="xs" class="p-0 border-0"
        :class="props.class" :content="flashMessage" />
    <fg-alert v-if="errorMessage" v-bind="$attrs" type="error" outline size="xs" class="p-0 border-0"
        :class="props.class" :content="errorMessage" />
</template>
