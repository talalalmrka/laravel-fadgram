<script setup lang="ts">
import { computed } from 'vue';
import { useOptions } from '@/composables/useOptions';
import ImagePicker from './ImagePicker.vue';

interface BgImageAtts {
    bgImage?: string;
    bgSize?: string;
    bgPosition?: string;
    bgAttachment?: string;
}

const props = defineProps<{
    modelValue: BgImageAtts
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: BgImageAtts): void
}>();

const { bgSizeOptions, bgPositionOptions, bgAttachmentOptions } = useOptions();

// Create computed properties with getter/setter for each background attribute
const bgImage = computed({
    get: () => props.modelValue.bgImage,
    set: (value) => updateAtts({ bgImage: value })
});

const bgSize = computed({
    get: () => props.modelValue.bgSize,
    set: (value) => updateAtts({ bgSize: value })
});

const bgPosition = computed({
    get: () => props.modelValue.bgPosition,
    set: (value) => updateAtts({ bgPosition: value })
});

const bgAttachment = computed({
    get: () => props.modelValue.bgAttachment,
    set: (value) => updateAtts({ bgAttachment: value })
});

function updateAtts(updatedProps: Partial<BgImageAtts>) {
    emit('update:modelValue', { ...props.modelValue, ...updatedProps });
}
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <ImagePicker v-model="bgImage" />
        </div>
        <div class="col">
            <fg-select v-model="bgSize" label="Background size" :options="bgSizeOptions" class="sm" />
        </div>
        <div class="col">
            <fg-select v-model="bgPosition" label="Background position" :options="bgPositionOptions" class="sm" />
        </div>
        <div class="col">
            <fg-select v-model="bgAttachment" label="Background attachment" :options="bgAttachmentOptions" class="sm" />
        </div>
    </div>
</template>
