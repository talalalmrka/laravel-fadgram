<script setup lang="ts">
import { computed, ref } from 'vue'
import { TransitionExpand } from '@morev/vue-transitions'

const props = withDefaults(defineProps<{
    title?: string
    icon?: string
    open?: boolean
    panelClass?: string
}>(), {
    open: true
})

const emit = defineEmits(['update:modelValue'])

const open = ref<boolean>(props.open)

const toggle = () => {
    open.value = !open.value
}
</script>
<template>
    <div class="bg-white dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 text-sm" v-bind="$attrs">
        <div @click="toggle"
            class="cursor-pointer flex items-center bg-gray-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 font-medium hover:text-primary dark:hover:text-primary-500 transition-colors"
            :class="{ 'bg-gray-50 dark:bg-gray-600': open }">
            <div class="flex-1 flex-space-2 px-3">
                <slot name="icon">
                    <span v-if="icon" class="px-3 py-2">
                        <fg-icon :icon="icon" />
                    </span>
                </slot>
                <slot name="title">
                    <span class="px-3 py-2" v-if="title">{{ title }}</span>
                </slot>
            </div>
            <button type="button" class="flex items-center px-3 py-2">
                <i class="icon bi-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>
        </div>
        <transition-expand>
            <div v-show="open" class="border-t border-gray-200 dark:border-gray-600 px-3 py-2" :class="panelClass">
                <slot />
            </div>
        </transition-expand>
    </div>
</template>
