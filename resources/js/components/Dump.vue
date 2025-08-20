<script setup lang="ts">
import { useSlots, computed } from 'vue'
const props = defineProps<{
    content?: any
}>()
/* const props = defineProps({
    devOnly: {
        type: Boolean,
        default: true
    }
}) */

const slots = useSlots()
const slot = computed(() => slots.default?.())
const value = computed(() => {
    const slot = slots.default?.()
    // Try to extract value from default slot
    if (slot && slot.length === 1 && 'children' in slot[0]) {
        return slot[0].children
    }
    return slot ?? props.content;
})

</script>

<template>
    <pre>{{ value }}</pre>
</template>
