<script setup lang="ts">
import { computed } from 'vue'
import { FgCheckbox } from 'fadgram-vue'

const props = defineProps<{
    categories: CategoryType[];
    level: number;
    modelValue: string[];
}>();

const emit = defineEmits(['update:modelValue'])

const localValue = computed({
    get: () => props.modelValue,
    set: (val: string[]) => emit('update:modelValue', val),
});

</script>

<template>
    <ul v-bind="$attrs" v-if="categories?.length" class="list-none m-0" :class="{ 'p-0': level < 1 }">
        <li v-for="category in categories" :key="category.id" class="pt-1">
            <fg-checkbox :label="category.name" :value="category.id" v-model="localValue" />
            <categories-checkbox-group v-if="category.children" :categories="category.children" :level="level + 1"
                v-model="localValue" />
        </li>
    </ul>
</template>
