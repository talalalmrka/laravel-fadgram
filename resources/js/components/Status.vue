<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { FgAlert } from 'fadgram-vue'

interface Props {
  name: string
  class?: string
}

const props = defineProps<Props>()

interface InertiaPageProps {
  errors?: Record<string, string | string[]>
  flash?: Record<string, string | undefined>
  [key: string]: any
}

// Correctly type the page props
const page = usePage<InertiaPageProps>()

const errorMessage = computed(() => {
  // TypeScript now knows page.props.errors is a Record<string, string | string[]>
  const error = page.props.errors?.[props.name]
  if (typeof error === 'string') return error
  if (Array.isArray(error)) return error[0]
  return null
})

const flashMessage = computed(() => {
  // TypeScript now knows page.props.flash is a Record<string, string | undefined>
  return page.props.flash?.[props.name] || null
})
</script>

<template>
  <!-- Template remains unchanged -->
  <fg-alert v-if="flashMessage" v-bind="$attrs" type="success" outline size="xs" class="p-0 border-0"
    :class="props.class" :content="flashMessage" />
  <fg-alert v-if="errorMessage" v-bind="$attrs" type="error" outline size="xs" class="p-0 border-0" :class="props.class"
    :content="errorMessage" />
</template>