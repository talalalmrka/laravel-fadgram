<script setup lang="ts">
import { computed, ref, useTemplateRef, watch, onMounted, onUnmounted } from 'vue'
import { uniqid } from '@/helpers/uniqid';
import { usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { PageType } from '@/types';
import axios from 'axios';
import { MediaType } from '@/types/media';
import eventBus from '@/types/eventBus';

const props = defineProps<{
    id?: string;
    label?: string;
    icon?: string;
    info?: string;
    error?: string;
    modelType?: string
    modelId?: number
    collection?: string
    modelValue: string | null | undefined
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | null): void
}>()
const page = usePage<{ props: { page: PageType } }>();
const pageId = (page as any)?.props?.page?.id;
const inputId = ref(props.id || uniqid('image-input-'));
const imageUrl = ref<string | null | undefined>(props.modelValue)
const input = useTemplateRef('image-input')
const progress = ref(0);
const uploading = ref(false)
const image = ref<MediaType | null | undefined>(undefined)
const conversions = ref<Record<string, string> | undefined>(undefined);
const conversion = ref<string | undefined>(undefined)

// conversionOptions as select options
const conversionOptions = computed(() => {
    if (!conversions.value) return [];
    return Object.entries(conversions.value).map(([key, url]) => ({
        label: key,
        value: key,
    }));
});

// Watch for external modelValue changes
watch(
    () => props.modelValue,
    (val) => {
        imageUrl.value = val
    }
)

// Emit changes when imageUrl is updated
function updateValue(val: string | null) {
    imageUrl.value = val
    emit('update:modelValue', val)
}

// Example: handle file input change (for image upload)
function onFileChange(event: Event) {
    const target = event.target as HTMLInputElement
    if (target.files && target.files[0]) {
        const file = target.files[0]
        // For now, just create a local URL (in real use, upload to server and get URL)
        const url = URL.createObjectURL(file)
        imageUrl.value = url;
        upload(file)
        // updateValue(url)
    }
}

// Example: clear image
function clear() {
    updateValue(null)
}
watch(
    () => image.value,
    (val) => {
        if (val && val.original_url) {
            conversions.value = val.conversions
            if (val.conversions) {
                conversion.value = Object.keys(val.conversions)[0] || undefined;
            }
            updateValue(val.original_url);
        }
    }
);
watch(
    () => conversion.value,
    (newConversion) => {
        if (newConversion) {
            const url = conversions.value && newConversion in conversions.value ? conversions.value[newConversion] : null;
            updateValue(url);
        }
    }
);
const upload = async (file: File) => {
    uploading.value = true
    const formData = new FormData();
    formData.append('image', file);
    try {
        // const pageId = (page as any)?.props?.page?.id;
        if (!pageId) throw new Error('Page ID is missing');
        const response = await axios.post(route('builder.upload', { page: pageId }), formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            onUploadProgress(evt) {
                if (evt.total) progress.value = (evt.loaded / evt.total) * 100;
            },
        });
        const img = response.data as MediaType;
        image.value = img;

    } catch (error) {
        uploading.value = false
        console.error('Error uploading image:', error);
        alert('Error uploading image.');
    } finally {
        uploading.value = false;
    }
}

function pickImage() {
    eventBus.emit('openMediaModal', {
        id: inputId.value,
        title: 'Select image',
        type: 'image',
        model_type: 'post',
        model_id: pageId,
        collection: 'images',
        multiple: false,
    });
}

onMounted(() => {
    eventBus.on('mediaSelected', (data) => {
        console.log('mediaSelected', data)
        if (data.id === inputId.value) {
            image.value = data.media as MediaType;
        }
    });
});

onUnmounted(() => {
    eventBus.off('mediaSelected');
});
</script>
<template>
    <fg-label :icon="icon" :label="label" :error="error" :for="inputId" />
    <input type="file" @input="onFileChange" class="hidden" ref="image-input" accept="image/*" />
    <div class="relative aspect-video rounded border overflow-hidden">
        <img v-if="imageUrl" :src="imageUrl" class="w-full h-full object-cover">
        <button @click="clear" v-show="imageUrl" type="button"
            class="btn btn-red p-0 space-x-0 inline-flex items-center justify-center w-6 h-6 rounded-full absolute top-2 start-2"
            aria-label="Remove">
            <fg-icon icon="bi-trash" />
        </button>
        <div class="absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2 flex-space-2">
            <button @click="input?.click()" type="button"
                class="btn btn-primary p-0 space-x-0 inline-flex items-center justify-center w-8 h-8 rounded-full"
                aria-label="Upload">
                <fg-icon icon="bi-cloud-upload" />
            </button>
            <button @click="pickImage" type="button"
                class="btn btn-green p-0 space-x-0 inline-flex items-center justify-center w-8 h-8 rounded-full"
                aria-label="Select">
                <fg-icon icon="bi-image" />
            </button>
        </div>
    </div>
    <div v-if="uploading" class="progress" role="progressbar">
        <div class="progress-bar" :style="{ 'width': `${progress}%` }">{{ progress }}%
        </div>
    </div>
    <fg-info :info="info" />
    <fg-error :error="error" />
    <div v-if="conversions" class="mt-3">
        <fg-select label="Resolution" :options="conversionOptions" v-model="conversion" />
    </div>
</template>
