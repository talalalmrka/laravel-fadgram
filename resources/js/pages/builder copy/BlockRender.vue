<script setup lang="ts">
import { BlockType } from '@/types'
import { ref, watch } from 'vue'
import { route } from 'ziggy-js'

// define props
const props = defineProps<{
    block: BlockType
    active: boolean
}>()

// where we'll store the server-rendered HTML
const renderedHtml = ref<string>('')
const renderUrl = ref<string>('')
const previewUrl = ref<string>('')
const isLoading = ref<boolean>(false)
// watch for any change in props.block (deeply), and run immediately
watch(
    () => props.block,
    (newBlock) => {
        renderUrl.value = route('builder.block', { ...newBlock })
        previewUrl.value = route('builder.block.preview', { ...newBlock })
        isLoading.value = true
        fetch(renderUrl.value, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN':
                    (document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content')) || ''
            },
            body: JSON.stringify(newBlock),
        })
            .then((res) => {
                isLoading.value = false
                if (!res.ok) throw new Error(res.statusText)
                return res.text()
            })
            .then((html) => {
                renderedHtml.value = html
            })
            .catch((err) => {
                isLoading.value = false
                console.error('Error loading block content:', err)
            })
    },
    { immediate: true, deep: true }
)
</script>

<template>
    <div :id="props.block.id" v-bind="$attrs" :class="{ 'ring-primary/50 ring-3 rounded': active }"
        class="relative hover:ring-primary/50 hover:ring-3 hover:rounded">
        <div v-show="active" class="nav px-3 bg-gray-100 dark:bg-gray-700">
            <a class="nav-link" :href="previewUrl" target="_blank" title="View block">
                <i class="icon bi-box-arrow-up-right"></i>
                <span>Preview</span>
            </a>

        </div>
        <i v-show="isLoading"
            class="icon fg-loader-dots-move text-2xl absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"></i>
        <div v-html="renderedHtml">
        </div>
    </div>

</template>
