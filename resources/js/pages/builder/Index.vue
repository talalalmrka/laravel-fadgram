<script setup lang="ts">
import { ref, watch, nextTick, onMounted, onUnmounted } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

import { BlockType, InertiaPageProps, PageType } from '@/types'
import Inspector from './Inspector.vue'
import Editor from './Editor.vue'
import SelectPage from './SelectPage.vue'
import AddBlock from './AddBlock.vue'
import Toast from "fadgram-ui/helpers/toast";
import MediaModal from '@/components/MediaModal.vue'
import eventBus from '@/types/eventBus'
import RenderBlocks from './RenderBlocks.vue'
import Dump from '@/components/Dump.vue'
import { useBlockAllowed, useBlocks } from '@/composables/useBlocks'
import { uniqid } from '@/helpers/uniqid'
import Render from './Render.vue'

const props = defineProps<{
    page: PageType
}>()
const pageData = usePage<{ props: InertiaPageProps }>();
// Sidebar toggles
const showInspector = ref(true)
const showEditor = ref(false)
const showAddBlock = ref(false);


const activeBlock = ref<BlockType>()

// Wrap the initial blocks in a ref so that dragging mutations are tracked
const initialBlocks = ref((props.page?.blocks ?? []).slice())

// Inertia form tracking
const form = useForm({
    blocks: initialBlocks.value
})

const toggleInspector = () => {
    if (!showInspector.value) {
        showAddBlock.value = false;
    }
    showInspector.value = !showInspector.value
}
const toggleEditor = () => { showEditor.value = !showEditor.value }
const toggleAddBlock = () => {
    if (!showAddBlock.value) {
        showInspector.value = false;
    }
    showAddBlock.value = !showAddBlock.value;
}
const findAndAddBlock = (blocks: BlockType[], parentId: string, blockToAdd: BlockType): boolean => {
    for (const block of blocks) {
        if (block.id === parentId) {
            if (!block.children) {
                block.children = [];
            }
            block.children.push(blockToAdd);
            return true;
        }
        if (block.children && findAndAddBlock(block.children, parentId, blockToAdd)) {
            return true;
        }
    }
    return false;
};
const addBlock = (block: BlockType) => {
    const allowed = useBlockAllowed(block.type, activeBlock.value?.type);
    if (!allowed) {
        Toast.warning(`Cannot add block: ${block.type} to ${activeBlock.value?.type}`);
        return;
    }
    if (activeBlock.value) {
        findAndAddBlock(form.blocks, activeBlock.value.id, block);
    } else {
        form.blocks.push(block);
    }
    editBlock(block);
}
const updatedBlocks = (blocks: BlockType[]) => {
    form.blocks = blocks;
}
const editBlock = (block: BlockType) => {
    if (!showEditor.value) showEditor.value = true
    activeBlock.value = block
}
const deleteBlock = (block: BlockType) => {
    const findAndRemoveBlock = (blocks: BlockType[], blockId: string): boolean => {
        for (let i = 0; i < blocks.length; i++) {
            if (blocks[i].id === blockId) {
                blocks.splice(i, 1);
                return true;
            }
            if (blocks[i].children && findAndRemoveBlock(blocks[i].children ?? [], blockId)) {
                return true;
            }
        }
        return false;
    };
    findAndRemoveBlock(form.blocks, block.id);
    // If the deleted block was active, clear the activeBlock
    if (activeBlock.value && activeBlock.value.id === block.id) {
        activeBlock.value = undefined;
        showEditor.value = false;
    }
}
const moveUp = (block: BlockType) => {
    const findAndStepTop = (blocks: BlockType[], blockId: string): boolean => {
        for (let i = 0; i < blocks.length; i++) {
            if (blocks[i].id === blockId) {
                if (i > 0) {
                    // Move block to top of current level
                    const [movedBlock] = blocks.splice(i, 1);
                    blocks.unshift(movedBlock);
                }
                return true;
            }
            if (blocks[i].children && findAndStepTop(blocks[i].children ?? [], blockId)) {
                return true;
            }
        }
        return false;
    };
    findAndStepTop(form.blocks, block.id);
}
const moveDown = (block: BlockType) => {
    const findAndStepDown = (blocks: BlockType[], blockId: string): boolean => {
        for (let i = 0; i < blocks.length; i++) {
            if (blocks[i].id === blockId) {
                if (i < blocks.length - 1) {
                    // Move block to bottom of current level
                    const [movedBlock] = blocks.splice(i, 1);
                    blocks.push(movedBlock);
                }
                return true;
            }
            if (blocks[i].children && findAndStepDown(blocks[i].children ?? [], blockId)) {
                return true;
            }
        }
        return false;
    };
    findAndStepDown(form.blocks, block.id);
}
const removeActive = () => {
    activeBlock.value = undefined;
}
// Submit
function submit() {
    form.post(route('builder.store', { page: props.page.id }), {
        preserveScroll: true,
        onSuccess: (page) => {

            // toast success
            const flashes = page.props.flash;
            if (flashes && Object.prototype.hasOwnProperty.call(flashes, 'save')) {
                const successMessage = (flashes as Record<string, string | undefined>)['save']
                if (successMessage) {
                    Toast.success(successMessage, 'bottom-start');
                }
            }

            // Toast error
            const errs = page.props.errors;
            if (errs && !Object.prototype.hasOwnProperty.call(errs, 'save')) {
                const errorMessage = errs['save'];
                if (errorMessage) {
                    Toast.error(errorMessage, 'bottom-start');
                }
            }

        },
    });
}
watch(activeBlock, (newActiveBlock) => {
    if (newActiveBlock && newActiveBlock.id) {
        nextTick(() => {
            const el = document.querySelector(`[data-block-id="${newActiveBlock.id}"]`);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }
    if (!newActiveBlock) {
        showEditor.value = false;
    }
});

onMounted(() => {
    eventBus.on('editBlock', editBlock);
    eventBus.on('addBlock', addBlock);
    eventBus.on('openAddBlock', (block: BlockType) => {
        activeBlock.value = block;
        showInspector.value = false;
        showAddBlock.value = true;
    });
    eventBus.on('moveUp', moveUp)
    eventBus.on('moveDown', moveDown)
});

onUnmounted(() => {
    eventBus.off('editBlock');
    eventBus.off('addBlock');
    eventBus.off('openAddBlock');
    eventBus.off('moveUp');
    eventBus.off('moveDown');
});

</script>

<template>
    <div class="relative h-screen overflow-y-hidden flex flex-col">
        <!-- Navbar -->
        <div class="h-11 bg-gray-100 dark:bg-gray-700 border-b px-4 flex items-center justify-between z-20">
            <div class="flex gap-2 justify-start">
                <button @click="toggleAddBlock" type="button"
                    class="rounded font-bold flex items-center justify-center p-2"
                    :class="{ 'bg-primary text-white': showAddBlock, 'hover:bg-primary-100 hover:text-primary': !showAddBlock }">
                    <fg-icon icon="bi-plus-circle" class="text-base" />
                </button>
                <button @click="toggleInspector" type="button"
                    class="rounded font-bold flex items-center justify-center p-2"
                    :class="{ 'bg-primary text-white': showInspector, 'hover:bg-primary-100 hover:text-primary': !showInspector }">
                    <fg-icon icon="bi-list-nested" />
                </button>

            </div>
            <div class="flex gap-2 justify-center">
                <SelectPage class="w-40" />
            </div>
            <div class="flex gap-2 items-center justify-end">
                <a class="rounded font-bold flex items-center justify-center p-2 hover:bg-primary hover:text-white"
                    :href="route('builder.classic', { page: page.id })" title="Classic editor">
                    <i class="icon bi-pencil-square"></i>
                </a>
                <a class="rounded font-bold flex items-center justify-center p-2 hover:bg-primary hover:text-white"
                    :href="page.permalink" target="_blank" title="View page">
                    <i class="icon bi-box-arrow-up-right"></i>
                </a>
                <button @click="toggleEditor" type="button"
                    class="rounded font-bold flex items-center justify-center p-2"
                    :class="{ 'bg-primary text-white': showEditor, 'hover:bg-primary-100 hover:text-primary': !showEditor }">
                    <i class="icon bi-layout-sidebar-reverse"></i>
                </button>

                <fg-button sm icon="bi-save" label="Save" color="primary" @click="submit">
                    <fg-icon icon="bi-save" />
                    <span>Save</span>
                    <fg-loader v-if="form.processing" dots-scale />
                </fg-button>
            </div>
        </div>

        <!-- Inspector -->
        <Inspector :show="showInspector" :blocks="form.blocks" :active-block="activeBlock"
            @update:blocks="updatedBlocks" @close="showInspector = false" @edit="editBlock" @remove="deleteBlock"
            @remove-active="removeActive" />

        <!-- Add block -->
        <AddBlock :show="showAddBlock" @close="showAddBlock = false" :active-block="activeBlock" />

        <!-- Editor Sidebar -->
        <Editor :show="showEditor" :block="activeBlock" @close="showEditor = false" @edit="editBlock"
            :key="activeBlock?.id ?? uniqid('editor')" />

        <!-- Main Content -->
        <div @click.stop="removeActive" class="flex-1 overflow-y-auto relative"
            :class="{ 'md:ps-80': showInspector || showAddBlock, 'md:pe-72': showEditor }">
            <div class="">
                <div class="space-y-3">
                    <Render v-for="block in form.blocks" :block="block" :key="block.id" :active-block="activeBlock"
                        @edit="editBlock" @remove="deleteBlock" />
                </div>
                <!-- <RenderBlocks v-model="form.blocks" class="mt-4" :active-block="activeBlock" @edit="editBlock"
                    @remove="deleteBlock" /> -->
            </div>
        </div>
    </div>
    <MediaModal />
</template>
