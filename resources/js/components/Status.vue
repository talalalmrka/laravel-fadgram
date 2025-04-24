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
  errors: Record<string, string | string[]>
  flash?: Record<string, string>
}

const page = usePage<{ props: InertiaPageProps }>()

const errorMessage = computed(() => {
  const error = page.props.errors?.[props.name]
  if (typeof error === 'string') return error
  if (Array.isArray(error)) return error[0]
  return null
})

const flashMessage = computed(() => {
  return page.props.flash?.[props.name] || null
})
</script>

<template>
  <fg-alert v-if="flashMessage" v-bind="$attrs" success outline size="xs" class="p-0 border-0" :class="class"
    :content="flashMessage" />
  <fg-alert v-if="errorMessage" v-bind="$attrs" error outline size="xs" class="p-0 border-0" :class="class"
    :content="errorMessage" />
</template>
