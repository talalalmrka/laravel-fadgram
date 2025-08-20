<script setup lang="ts">
import { ref, watch, nextTick, onMounted, onUnmounted } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { BaseBlock, BlockType, InertiaPageProps, PageType } from '@/types'
import Inspector from './Inspector.vue'
import Editor from './Editor.vue'
import SelectPage from './SelectPage.vue'
import AddBlock from './AddBlock.vue'
import BlockRender from './BlockRender.vue'
import Toast from "fadgram-ui/helpers/toast";
import MediaModal from '@/components/MediaModal.vue'
import eventBus from '@/types/eventBus'
import ContainerRender from './ContainerRender.vue'

const props = defineProps<{
    page: PageType
    registeredBlocks: BaseBlock[]
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

const addBlock = (block: BlockType) => {
    form.blocks.push(block);
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
    const idx = form.blocks.findIndex(b => b.id === block.id)
    if (idx !== -1) {
        form.blocks.splice(idx, 1)
        // If the deleted block was active, clear the activeBlock
        if (activeBlock.value && activeBlock.value.id === block.id) {
            activeBlock.value = undefined
            showEditor.value = false
        }
    }
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
    // Scroll to the active block in the rendered preview when it changes
    if (newActiveBlock && newActiveBlock.id) {
        // Wait for DOM update
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
    eventBus.on('deleteBlock', deleteBlock)
});

onUnmounted(() => {
    eventBus.off('editBlock');
    eventBus.off('deleteBlock');
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

                <fg-button xs icon="bi-save" label="Save" color="primary" @click="submit">
                    <fg-icon icon="bi-save" />
                    <span>Save</span>
                    <fg-loader v-if="form.processing" dots-scale />
                </fg-button>
            </div>
        </div>

        <!-- Inspector -->
        <Inspector :show="showInspector" :blocks="form.blocks" :active-block="activeBlock" @edit-block="editBlock"
            @delete-block="deleteBlock" @update:blocks="updatedBlocks" @close="showInspector = false" />

        <!-- Add block -->
        <AddBlock :show="showAddBlock" @add-block="addBlock" @close="showAddBlock = false" />

        <!-- Editor Sidebar -->
        <Editor :show="showEditor" :block="activeBlock" @close="showEditor = false" :key="activeBlock?.id"
            @edit="editBlock" />

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto relative"
            :class="{ 'md:ps-72': showInspector, 'md:pe-72': showEditor, 'md:ps-80': showAddBlock }">
            <div class="p-4">
                <template v-for="block in form.blocks">
                    <ContainerRender v-if="block.type === 'container'" :block="block" />
                    <BlockRender v-else :block="block" @click="editBlock(block)" :active="block.id === activeBlock?.id"
                        :data-block-id="block.id" />
                </template>

            </div>
        </div>
    </div>
    <MediaModal />
</template>
