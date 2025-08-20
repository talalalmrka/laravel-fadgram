<script setup lang="ts">
import { useError } from '@/composables/useError';
import { useFlash } from '@/composables/useFlash';
import { ref } from 'vue';

const errorMessage = useError('status')
const successMessage = useFlash('status')
const su = ref(successMessage)
const showSuccess = ref(true)
const showError = ref(true)
</script>

<template>
    <div v-if="errorMessage || successMessage" class="sticky top-0">
        <div v-show="showSuccess" v-if="successMessage" class="alert alert-success flex-space-2">
            <div class="flex-1 flex-space-2">
                <fg-icon icon="bi-check2-circle" />
                <span>{{ su }}</span>
            </div>
            <button @click="showSuccess = !showSuccess" type="button">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
        <div v-show="showError" v-if="errorMessage" class="alert alert-error flex-space-2">
            <div class="flex-1 flex-space-2">
                <fg-icon icon="bi-exclamation-circle" />
                <span>{{ errorMessage }}</span>
            </div>
            <button @click="showError = !showError" type="button">
                <fg-icon icon="bi-x-lg" />
            </button>
        </div>
    </div>
</template>
