<script setup lang="ts">
import { MediaType } from '@/types/media';

const props = defineProps<{
    media: MediaType
    selected?: boolean
}>()
const emit = defineEmits(['select'])
const icons = {
    'ai': 'bi-filetype-ai',
    'aac': 'bi-filetype-aac',
    'aif': 'bi-filetype-aif',
    'bmp': 'bi-filetype-bmp',
    'cs': 'bi-filetype-cs',
    'css': 'bi-filetype-css',
    'csv': 'bi-filetype-csv',
    'doc': 'bi-filetype-doc',
    'docx': 'bi-filetype-docx',
    'exe': 'bi-filetype-exe',
    'gif': 'bi-filetype-gif',
    'heic': 'bi-filetype-heic',
    'html': 'bi-filetype-html',
    'java': 'bi-filetype-java',
    'jpg': 'bi-filetype-jpg',
    'js': 'bi-filetype-js',
    'json': 'bi-filetype-json',
    'jsx': 'bi-filetype-jsx',
    'key': 'bi-filetype-key',
    'm4p': 'bi-filetype-m4p',
    'md': 'bi-filetype-md',
    'mdb': 'bi-filetype-mdb',
    'mid': 'bi-filetype-mid',
    'mov': 'bi-filetype-mov',
    'mp3': 'bi-filetype-mp3',
    'mp4': 'bi-filetype-mp4',
    'mpeg': 'bi-filetype-mpeg',
    'mpg': 'bi-filetype-mpg',
    'odt': 'bi-filetype-odt',
    'ogg': 'bi-filetype-ogg',
    'pdf': 'bi-filetype-pdf',
    'php': 'bi-filetype-php',
    'png': 'bi-filetype-png',
    'ppt': 'bi-filetype-ppt',
    'pptx': 'bi-filetype-pptx',
    'psd': 'bi-filetype-psd',
    'py': 'bi-filetype-py',
    'raw': 'bi-filetype-raw',
    'rb': 'bi-filetype-rb',
    'sass': 'bi-filetype-sass',
    'scss': 'bi-filetype-scss',
    'sh': 'bi-filetype-sh',
    'sql': 'bi-filetype-sql',
    'svg': 'bi-filetype-svg',
    'tiff': 'bi-filetype-tiff',
    'ts': 'bi-filetype-ts',
    'tsx': 'bi-filetype-tsx',
    'ttf': 'bi-filetype-ttf',
    'txt': 'bi-filetype-txt',
    'wav': 'bi-filetype-wav',
    'woff': 'bi-filetype-woff',
    'xls': 'bi-filetype-xls',
    'xlsx': 'bi-filetype-xlsx',
    'xml': 'bi-filetype-xml',
    'yml': 'bi-filetype-yml',
}
</script>

<template>
    <div :key="media.id" @click="emit('select', media)"
        class="cursor-pointer border rounded relative overflow-hidden aspect-video"
        :class="{ 'ring-2 ring-primary': selected }">
        <img v-if="media.mime_type.startsWith('image')" :src="media.original_url" class="w-full h-full object-cover" />

        <div v-else class="w-full h-full flex items-center justify-center bg-gray-100">
            <i class="icon text-4xl text-gray-400" :class="icons[media.ext as keyof typeof icons]"></i>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-xs px-1 truncate">
            {{ media.file_name }}
        </div>
        <div v-if="selected" class="absolute inset-0 bg-black/30">
        </div>
        <i v-if="selected"
            class="icon bi-check2-circle absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2 text-3xl text-white"></i>
    </div>
</template>
