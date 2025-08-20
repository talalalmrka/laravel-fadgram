<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    modelValue?: string | undefined;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | undefined): void;
}>();

const newTab = computed<boolean>({
    get() {
        return props.modelValue === '_blank';
    },
    set(val: boolean) {
        const target = val ? '_blank' : '_self';
        emit('update:modelValue', target);
    },
});
</script>

<template>
    <fg-switch v-bind="$attrs" v-model="newTab" />
</template>
