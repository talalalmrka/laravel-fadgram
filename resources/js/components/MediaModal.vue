<script setup lang="ts">
import { ref, onMounted, watch, useTemplateRef } from 'vue';
import EventBus from '@/types/event-bus';
import axios from 'axios';
import { route } from 'ziggy-js';
import { MediaType } from '@/types/media';
import { useForm } from '@inertiajs/vue3';
import MediaItem from './MediaItem.vue';
import { uniqid } from '@/helpers/uniqid';

const isOpen = ref(false);
const mediaList = ref<MediaType[]>([]);
const selectedIds = ref<number[]>([]);
const selectedMedia = ref<MediaType[]>([]);
const multiple = ref(false);
const page = ref<number>(1)
const fileToUpload = ref<File>();
const uploading = ref(false)
const progress = ref(0);
const dragOver = ref(false);
const title = ref<string>('Select media');
const selectLabel = ref<string>('Select');
const closeLabel = ref<string>('Close');
const model_type = ref<string | undefined>(undefined);
const model_id = ref<number | undefined>(undefined);
const collection = ref<string | undefined>(undefined);
const tab = ref<string>('library');
const loading = ref<boolean>(false)
const fileInput = useTemplateRef('file-input');
const loadingErrorMessage = ref<string | undefined | null>(undefined)
const id = ref(uniqid('media-'))
const typeOptions = [
    {
        label: 'All',
        value: '',
    },
    {
        label: 'Images',
        value: 'image',
    },
    {
        label: 'Pdf',
        value: 'pdf',
    }
];
const filters = useForm({
    type: undefined as string | undefined,
    search: undefined as string | undefined,
})
watch(filters, () => {
    page.value = 1;
    loadMedia();
}, { deep: true });
const isTab = (key: string) => {
    return tab.value === key
}
const toggleTab = (key: string) => {
    tab.value = key
}
function open(options: {
    id: string
    multiple?: boolean,
    title?: string,
    selectLabel?: string,
    closeLabel?: string,
    model_type?: string,
    model_id?: number,
    type?: string,
    collection?: string
}) {
    id.value = options.id
    multiple.value = !!options.multiple;
    title.value = options.title || 'Select media';
    selectLabel.value = options.selectLabel || 'Select';
    closeLabel.value = options.closeLabel || 'Close';
    model_type.value = options.model_type;
    model_id.value = options.model_id;
    filters.type = options.type;
    collection.value = options.collection;
    loadMedia();
    isOpen.value = true;
}

function close() {
    isOpen.value = false;
    selectedIds.value = [];
    selectedMedia.value = [];
    fileToUpload.value = undefined;
}

async function loadMedia() {
    loading.value = true
    loadingErrorMessage.value = undefined
    try {
        const params: Record<string, string | number> = {};
        if (model_type.value) {
            params['model_type'] = model_type.value;
        }
        if (model_id.value) {
            params['model_id'] = model_id.value;
        }
        if (filters.type) {
            params['type'] = filters.type;
        }
        if (page.value) {
            params['page'] = page.value;
        }
        if (filters.search) {
            params['search'] = filters.search;
        }

        const { data } = await axios.get(route('api.media', params));
        if (page.value === 1) {
            mediaList.value = data;
        } else {
            mediaList.value = [...mediaList.value, ...data];
        }

        loading.value = false
    } catch (error) {
        loading.value = false
        loadingErrorMessage.value = `Error: ${error}`;
    } finally {
        loading.value = false
    }
}
async function loadMore() {
    if (loading.value) return;
    page.value += 1;
    await loadMedia()
}

function toggleSelect(media: any) {
    if (multiple.value) {
        if (selectedIds.value.includes(media.id)) {
            selectedIds.value = selectedIds.value.filter((id) => id !== media.id);
            selectedMedia.value = selectedMedia.value.filter((m) => m.id !== media.id);
        } else {
            selectedIds.value.push(media.id);
            selectedMedia.value.push(media);
        }
    } else {
        if (selectedIds.value.includes(media.id)) {
            selectedIds.value = [];
            selectedMedia.value = [];
        } else {
            selectedIds.value = [media.id];
            selectedMedia.value = [media];
        }

    }
}

function confirmSelection() {
    if (multiple.value) {
        EventBus.emit('mediaSelected', {
            id: id.value,
            media: selectedMedia.value,
        });
    } else {
        EventBus.emit('mediaSelected', {
            id: id.value,
            media: selectedMedia.value[0],
        });
    }
    close();
}

function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        uploadFile(target.files[0]);
    }
}

async function uploadFile(file: File) {
    uploading.value = true
    const formData = new FormData();
    formData.append('file', file);
    try {
        const params: Record<string, string | number> = {};
        if (model_type.value) {
            params['model_type'] = model_type.value;
        }
        if (model_id.value) {
            params['model_id'] = model_id.value;
        }
        if (collection.value) {
            params['collection'] = collection.value;
        }
        const { data: newMedia } = await axios.post(route('api.media.store', params), formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress(evt) {
                if (evt.total) progress.value = (evt.loaded / evt.total) * 100;
            },
        });
        uploading.value = false;
        mediaList.value.unshift(newMedia);
        toggleSelect(newMedia)
        toggleTab('library')

    } catch (error) {
        uploading.value = false
        console.error('Error uploading image:', error);
        alert('Error uploading image.');
    } finally {
        uploading.value = false;
    }
}

// Drag & drop handlers
function onDragOver() {
    dragOver.value = true;
}
function onDragLeave() {
    dragOver.value = false;
}
function onDrop(e: DragEvent) {
    dragOver.value = false;
    if (e.dataTransfer?.files && e.dataTransfer?.files[0]) {
        uploadFile(e.dataTransfer?.files[0])
    }
}

onMounted(() => {
    EventBus.on('openMediaModal', open);
});
</script>

<template>
    <div v-show="isOpen" class="modal-backdrop show">
    </div>
    <div v-show="isOpen" class="modal fade show lg">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close" @click="close">
                        <i class="icon bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body p-0 flex flex-col">
                    <div class="sticky top-0 bg-body-bg dark:bg-body-bg-dark z-1">
                        <div class="border-b flex-space-1 mt-2">
                            <button @click="toggleTab('library')" type="button"
                                class="px-3 py-2 ms-3 flex-space-1 bg-body-bg dark:bg-body-bg-dark"
                                :class="{ 'border border-b-white -mb-px': isTab('library') }">
                                <fg-icon icon="bi-image" />
                                <span>Library</span>
                            </button>
                            <button @click="toggleTab('upload')" type="button"
                                class="px-3 py-2 flex-space-1 bg-body-bg dark:bg-body-bg-dark"
                                :class="{ 'border border-b-white -mb-px': isTab('upload') }">
                                <fg-icon icon="bi-cloud-upload" />
                                <span>Upload</span>
                            </button>
                        </div>
                        <div v-if="isTab('library')" class="flex-space-2 justify-between px-2 pt-2">
                            <div class="flex-1">
                                <fg-select class="sm max-w-40 pill" v-model="filters.type" :options="typeOptions" />
                            </div>
                            <div class="w-40">
                                <fg-input type="search" endIcon="bi-search" size="sm" class="max-w-40 pill"
                                    v-model="filters.search" placeholder="search" />
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 p-3">
                        <div v-show="isTab('library')" class="relative">
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                                <MediaItem v-for="media in mediaList" :media="media" :key="media.id"
                                    :selected="selectedIds.includes(media.id)" @select="toggleSelect" />
                            </div>
                            <fg-alert v-if="loadingErrorMessage" type="error" :content="loadingErrorMessage" />
                            <fg-alert v-if="!loading && !mediaList.length" type="info" soft content="No media found!" />
                            <button v-show="!loading" @click="loadMore" type="button"
                                class="btn btn-primary sm mt-3 mx-auto">
                                <span>Load more...</span>
                            </button>
                            <i v-show="loading"
                                class="icon fg-loader-dots-move text-2xl absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2"></i>
                        </div>
                        <div v-show="isTab('upload')" class="">
                            <input type="file" @input="handleFileChange" class="hidden" ref="file-input" />
                            <div @click="fileInput?.click()"
                                class="p-4 border-dashed border-2 rounded-md transition-colors cursor-pointer"
                                :class="dragOver ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-white'"
                                @dragover.prevent="onDragOver" @dragleave.prevent="onDragLeave" @drop.prevent="onDrop">
                                <div class="flex flex-col items-center gap-4 text-gray-500 dark:text-gray-400">
                                    <fg-icon icon="bi-cloud-upload" class="text-4xl mb-3" />
                                    <span>Click or drag & drop files here to upload</span>
                                </div>
                            </div>
                            <div v-if="uploading" class="progress absolute bottom-0 inset-x-0" role="progressbar">
                                <div class="progress-bar" :style="{ 'width': `${progress}%` }">{{ progress }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-space-2 justify-between">
                    <button type="button" class="btn btn-secondary" @click="close">{{ closeLabel }}</button>
                    <button type="button" class="btn btn-primary" @click="confirmSelection"
                        :disabled="!selectedIds.length">{{ selectLabel }}</button>
                </div>
            </div><!-- Modal Content -->
        </div><!-- Modal Dialog -->
    </div><!-- Modal -->
</template>
