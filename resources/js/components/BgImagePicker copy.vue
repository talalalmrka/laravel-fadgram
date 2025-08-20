<script setup lang="ts">
import { useOptions } from '@/composables/useOptions';
import ImagePicker from './ImagePicker.vue';
import { computed } from 'vue';
interface BgImageAtts {
    bgImage: string;
    bgSize: string;
    bgPosition: string;
    bgAttachment: string;
}
const props = defineProps<{
    modelValue: BgImageAtts;
}>();
const emit = defineEmits(['update:modelValue']);
const attsModel = computed({
    get() { return props.modelValue },
    set(value) { emit('update:modelValue', value) }
});
const { bgSizeOptions, bgPositionOptions, bgAttachmentOptions } = useOptions()
</script>

<template>
    <div class="grid grid-cols-1 gap-3">
        <div class="col">
            <ImagePicker v-model="attsModel.bgImage" />
        </div>
        <div class="col">
            <fg-select v-model="attsModel.bgSize" label="Background size" :options="bgSizeOptions" class="sm" />
        </div>
        <div class="col">
            <fg-select v-model="attsModel.bgPosition" label="Background position" :options="bgPositionOptions"
                class="sm" />
        </div>
        <div class="col">
            <fg-select v-model="attsModel.bgAttachment" label="Background attachment" :options="bgAttachmentOptions"
                class="sm" />
        </div>
    </div>

</template>
