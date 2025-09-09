<script setup lang="ts">
import { ref, watch, onMounted, nextTick } from 'vue';
import { Block } from '@/types';
import { useAttributes } from '@/composables/useAttributes';

const props = defineProps<{
    block: Block
}>();

const atts = useAttributes(props.block);

const isEditing = ref(false);
const textareaRef = ref<HTMLTextAreaElement | null>(null);

function autosize() {
    const ta = textareaRef.value;
    if (!ta) return;
    ta.style.height = 'auto';
    // add 2px to avoid scroll flicker on some browsers
    ta.style.height = (ta.scrollHeight + 2) + 'px';
}

function startEdit() {
    isEditing.value = true;
    // focus after DOM updates
    nextTick(() => {
        autosize();
        textareaRef.value?.focus();
        // move caret to end
        const ta = textareaRef.value;
        if (ta) {
            const len = ta.value.length;
            ta.setSelectionRange(len, len);
        }
    });
}

function stopEdit() {
    isEditing.value = false;
    // optional: trim trailing spaces/newlines if you want
    // atts.content = atts.content?.trimEnd();
}

// keep textarea sized when content changes externally
watch(() => atts.value.content, () => {
    nextTick(autosize);
});

// ensure proper size on mount
onMounted(() => {
    nextTick(autosize);
});
</script>

<template>
    <div class="relative">
        <!-- Rendered paragraph (non-edit) -->
        <p class="prose max-w-full whitespace-pre-wrap break-words cursor-text" @click="startEdit" v-bind="$attrs"
            aria-hidden="false">
            <!-- Show placeholder when empty -->
            <template v-if="!atts.content || atts.content.trim() === ''">
                <span class="text-gray-400">Type here…</span>
            </template>
            <template v-else>
                {{ atts.content }}
            </template>
        </p>

        <!-- Editing textarea overlay -->
        <textarea v-show="isEditing" ref="textareaRef" v-model="atts.content" @input="autosize" @blur="stopEdit"
            v-bind="$attrs" rows="1"
            class="absolute inset-0 w-full h-auto min-h-[1.5rem] resize-none border-0 p-0 m-0 text-inherit leading-normal outline-none whitespace-pre-wrap break-words"
            placeholder="Type here" style="overflow:hidden;"></textarea>
    </div>
</template>

<style scoped>
/* ensure the textarea visually matches the paragraph (font, spacing) */
textarea,
p {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}
</style>
