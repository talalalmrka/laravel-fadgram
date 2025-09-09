<script setup lang="ts">
import { ref, watch, nextTick, onMounted, onUnmounted, defineAsyncComponent, computed, onBeforeUnmount } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

import { Block, PageType, Pattern } from '@/types'
import {
    InspectorDraggable,
    RenderBlocks,
    MediaModal,
    AddBlockPanel,
    EditorPanel,
    PatternModal,
} from '@/components'
import SelectPage from './SelectPage.vue'
import Toast from "fadgram-ui/helpers/toast";
import EventBus from '@/types/event-bus'
import { resolveBlock, resolveBlocks, useBlockAllowed, useBlockDefaults, useBlockFeatures, useBlockLabel, useBlocks, useHasChildren } from '@/composables/useBlocks'
import { uniqid } from '@/helpers/uniqid'
import { defaultBlocks } from '@/composables/options/default-blocks'

const props = defineProps<{
    page: PageType
}>()

const showInspector = ref(true)
const showEditor = ref(false)
const showAddBlock = ref(false);
const showConsole = ref(false);
// const initialBlocks = ref(resolveBlocks(props.page.blocks ?? []))
const initialBlocks = ref<Block[]>(props.page.blocks ?? [])
const activeBlock = ref<Block | undefined>(undefined)
const copiedBlock = ref<Block | undefined>(undefined)
const form = useForm({
    blocks: initialBlocks.value
})

const toggleInspector = () => { showInspector.value = !showInspector.value }
const toggleEditor = () => { showEditor.value = !showEditor.value }
const closeEditor = () => { showEditor.value = false }
const toggleAddBlock = () => { showAddBlock.value = !showAddBlock.value }

const openAdd = (block: Block | undefined) => {
    activeBlock.value = block
    showAddBlock.value = true
}
const findIn = (blocks: Block[], blockId: string): Block | undefined => {
    for (const block of blocks) {
        if (block.id === blockId) {
            return block;
        }
        if (block.children) {
            const found = findIn(block.children, blockId);
            if (found) return found;
        }
    }
    return undefined;
}
const findBlock = (blockId: string): Block | undefined => {
    return findIn(form.blocks, blockId);
}
const addTo = (blocks: Block[], parentId: string, blockToAdd: Block): boolean => {
    for (const block of blocks) {
        if (block.id === parentId) {
            if (!block.children) {
                block.children = [];
            }
            block.children.push(blockToAdd);
            return true;
        }
        if (block.children && addTo(block.children, parentId, blockToAdd)) {
            return true;
        }
    }
    return false;
};
const add = (type: string) => {
    const allowed = useBlockAllowed(type, activeBlock.value?.type);
    if (!allowed) {
        Toast.warning(`Cannot add block: ${useBlockLabel(type)} to ${activeBlock.value?.type ? useBlockLabel(activeBlock.value.type) : 'the page!'}`);
        return;
    }
    const block = resolveBlock(type);
    if (block) {
        addBlock(block)
    } else {
        Toast.warning(`Could not resolve block type: ${type}`);
    }
}
const addBlock = (block: Block) => {
    const allowed = useBlockAllowed(block.type, activeBlock.value?.type);
    if (!allowed) {
        Toast.warning(`Cannot add block: ${useBlockLabel(block.type)} to ${activeBlock.value?.type ? useBlockLabel(activeBlock.value.type) : 'the page!'}`);
        return;
    }
    const resolvedBlock = resolveDuplicate(block);
    activeBlock.value ? addTo(form.blocks, activeBlock.value.id, resolvedBlock) : form.blocks.push(resolvedBlock);
    showInspector.value = true
    edit(resolvedBlock.id);
}
const addPattern = (pattern: Pattern) => {
    addBlock(pattern.block)
}
const resolveDuplicate = (block: Block) => {
    block.id = uniqid('block-');
    const children = block.children as Block[];
    if (children) {
        block.children = children.map((child) => resolveDuplicate(child))
    }
    return block;
}
const duplicate = (blockId: string) => {
    const findAndDuplicate = (blocks: Block[], blockId: string): Block | undefined => {
        for (const block of blocks) {
            if (block.id === blockId) {
                const duplicated = JSON.parse(JSON.stringify(block));
                return resolveDuplicate(duplicated);
            }
            if (block.children) {
                const found = findAndDuplicate(block.children, blockId);
                if (found) return found;
            }
        }
        return undefined;
    };

    const duplicated = findAndDuplicate(form.blocks, blockId);

    if (duplicated) {
        const findParentBlock = (blocks: Block[], blockId: string): Block | undefined => {
            for (const block of blocks) {
                if (block.children?.some(child => child.id === blockId)) {
                    return block;
                }
                if (block.children) {
                    const parent = findParentBlock(block.children, blockId);
                    if (parent) return parent;
                }
            }
            return undefined;
        };

        const parentBlock = findParentBlock(form.blocks, blockId);

        if (parentBlock) {
            if (!parentBlock.children) parentBlock.children = [];

            const idx = parentBlock.children.findIndex(child => child.id === blockId);
            if (idx !== -1) {
                parentBlock.children.splice(idx + 1, 0, duplicated);
            } else {
                parentBlock.children.push(duplicated);
            }
        } else {
            // top-level duplication
            const idx = form.blocks.findIndex(block => block.id === blockId);
            if (idx !== -1) {
                form.blocks.splice(idx + 1, 0, duplicated);
            } else {
                form.blocks.push(duplicated);
            }
        }
    }
}

const edit = (blockId: string | undefined) => {
    if (blockId) {
        const block: Block | undefined = findBlock(blockId)
        if (block) {
            activeBlock.value = block
            if (!showEditor.value) {
                showEditor.value = true
            }
        } else {
            Toast.warning('Block is currently not found!')
        }
    } else {
        activeBlock.value = undefined
    }
}

const removeFrom = (blocks: Block[], blockId: string): boolean => {
    for (let i = 0; i < blocks.length; i++) {
        if (blocks[i].id === blockId) {
            blocks.splice(i, 1);
            return true;
        }
        if (blocks[i].children && removeFrom(blocks[i].children ?? [], blockId)) {
            return true;
        }
    }
    return false;
}


const remove = (blockId: string) => {
    if (activeBlock.value && activeBlock.value.id === blockId) {
        activeBlock.value = undefined;
        showEditor.value = false;
    }
    removeFrom(form.blocks, blockId);
}


// find the array that contains the block and its index
const findParentArray = (
    blocks: Block[],
    blockId: string
): { array: Block[]; index: number } | null => {
    for (let i = 0; i < blocks.length; i++) {
        if (blocks[i].id === blockId) {
            return { array: blocks, index: i };
        }
        if (blocks[i].children) {
            const found = findParentArray(blocks[i].children!, blockId);
            if (found) return found;
        }
    }
    return null;
};

// move element in-place inside an array
const moveInArray = (arr: Block[], from: number, to: number) => {
    if (from === to) return;
    const [item] = arr.splice(from, 1);
    arr.splice(to, 0, item);
};

// generic move by step (-1 up, +1 down)
const move = (blockId: string, step: number): boolean => {
    const found = findParentArray(form.blocks, blockId);
    if (!found) return false;

    const { array, index } = found;
    const newIndex = Math.max(0, Math.min(array.length - 1, index + step));
    if (newIndex === index) return false;

    moveInArray(array, index, newIndex);
    return true;
};

// public helpers
const moveUp = (blockId: string) => move(blockId, -1);
const moveDown = (blockId: string) => move(blockId, +1);

// optional: move to first/last in same level
const moveToTop = (block: Block): boolean => {
    const found = findParentArray(form.blocks, block.id);
    if (!found) return false;
    moveInArray(found.array, found.index, 0);
    return true;
};
const moveToBottom = (block: Block): boolean => {
    const found = findParentArray(form.blocks, block.id);
    if (!found) return false;
    moveInArray(found.array, found.index, found.array.length - 1);
    return true;
};
const copy = () => {
    if (activeBlock.value) {
        copiedBlock.value = resolveDuplicate(activeBlock.value)
        Toast.success(`Copied: ${activeBlock.value.type}`);
    }
}
const paste = () => {
    if (copiedBlock.value) {
        const allowed = useBlockAllowed(copiedBlock.value.type, activeBlock.value?.type);
        if (!allowed) {
            Toast.warning(`Cannot add block: ${useBlockLabel(copiedBlock.value.type)} to ${activeBlock.value?.type ? useBlockLabel(activeBlock.value.type) : 'the page!'}`);
            return;
        }
        activeBlock.value ? addTo(form.blocks, activeBlock.value.id, copiedBlock.value) : form.blocks.push(copiedBlock.value);
    }
}
// Submit
function submit() {
    form.post(route('builder.store', { page: props.page.id }), {
        preserveScroll: true,
        showProgress: false,
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
const scrollToBlock = (id: string) => {
    const renderEl = document.querySelector(`[data-block-id="${id}"]`);
    if (renderEl) {
        renderEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    const inspectorEl = document.querySelector(`[data-inspector-id="${id}"]`);
    if (inspectorEl) {
        inspectorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
const isExporting = ref(false)
const resolveExport = (block: Block) => {
    const blockToExport: Partial<Block> = {
        type: block.type,
        attributes: block.attributes,
    };
    if (block.children) {
        blockToExport.children = block.children.map((child) => resolveExport(child)) as Block[];
    }
    return blockToExport as Block;
}
const exportBlocks = () => {
    isExporting.value = true;
    const blocks = form.blocks.map((b => resolveExport(b)));
    const data = JSON.stringify(blocks, null, 2);
    const blob = new Blob([data], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'blocks.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    isExporting.value = true;
}
watch(() => activeBlock.value, (val) => {
    if (val) {
        localStorage.setItem('activeBlock', val.id);
        nextTick(() => {
            scrollToBlock(val.id)
        });
    } else {
        localStorage.removeItem('activeBlock');
        showEditor.value = false
    }
});

watch(() => showInspector.value, (val) => {
    if (val && showAddBlock.value) {
        showAddBlock.value = false
    }
});

watch(() => showAddBlock.value, (val) => {
    if (val && showInspector.value) {
        showInspector.value = false
    }
});
onMounted(() => {
    EventBus.on('add', add)
    EventBus.on('addPattern', addPattern)
    EventBus.on('edit', edit)
    EventBus.on('remove', remove)
    EventBus.on('openAdd', openAdd)
    EventBus.on('duplicate', duplicate)
    EventBus.on('moveUp', moveUp)
    EventBus.on('moveDown', moveDown)
    EventBus.on('closeEditor', closeEditor)
    EventBus.on('resetActiveBlock', resetActiveBlock)

    const savedActiveBlockId = localStorage.getItem('activeBlock');
    if (savedActiveBlockId) {
        const savedActiveBlock = findBlock(savedActiveBlockId);
        if (savedActiveBlock) {
            edit(savedActiveBlock.id)
        }
    }
    window.addEventListener("keydown", onKeydown)
});

onBeforeUnmount(() => {
    EventBus.off('add')
    EventBus.off('addPattern')
    EventBus.off('edit')
    EventBus.off('remove')
    EventBus.off('openAdd')
    EventBus.off('duplicate')
    EventBus.off('moveUp')
    EventBus.off('moveDown')
    EventBus.off('closeEditor')
    EventBus.off('resetActiveBlock')
    window.removeEventListener("keydown", onKeydown)
});
const resetDefaultBlocks = () => {
    if (activeBlock.value) {
        activeBlock.value = undefined
    }
    form.blocks = defaultBlocks()
}

const resetBlocks = () => {
    if (activeBlock.value) {
        activeBlock.value = undefined
    }
    form.blocks = initialBlocks.value;
}
const resetActiveBlock = () => {
    if (activeBlock.value) {
        activeBlock.value.attributes = useBlockDefaults(activeBlock.value.type)
    }
}
const isEditableTarget = (el: EventTarget | null) => {
    if (!el || !(el as HTMLElement).tagName) return false
    const tag = (el as HTMLElement).tagName
    return (
        tag === 'INPUT' ||
        tag === 'TEXTAREA' ||
        tag === 'SELECT' ||
        (el as HTMLElement).isContentEditable
    )
}

const onKeydown = (e: KeyboardEvent) => {
    const isMod = e.metaKey || e.ctrlKey // support mac (meta) and win/linux (ctrl)
    if (!isMod) return

    // ignore when user is typing in form controls or contentEditable
    if (isEditableTarget(e.target)) return

    // if there's no active block, nothing to do
    const id = activeBlock.value?.id


    const key = e.key

    // delete (⌘/Ctrl + Delete or Backspace)
    if (key === 'Backspace' || key === 'Delete') {
        if (!id) return
        e.preventDefault()
        remove(id)
        return
    }

    // duplicate (⌘/Ctrl + D) — optionally ignore repeats so holding D doesn't spam duplicates
    if (key.toLowerCase && key.toLowerCase() === 'd') {
        if (!id) return
        if (e.repeat) return
        e.preventDefault()
        duplicate(id)
        return
    }

    // copy (⌘/Ctrl + C)
    /* if (key.toLowerCase && key.toLowerCase() === 'c') {
        if (!id) return
        if (e.repeat) return
        e.preventDefault()
        copy()
        return
    } */
    // paste (⌘/Ctrl + V)
    if (key.toLowerCase && key.toLowerCase() === 'v') {
        if (e.repeat) return
        e.preventDefault()
        paste()
        return
    }

    // Save (⌘/Ctrl + S)
    if (key.toLowerCase && key.toLowerCase() === 's') {
        if (e.repeat) return
        e.preventDefault()
        submit()
        return
    }

    // move down (⌘/Ctrl + ArrowDown)
    if (key === 'ArrowDown') {
        if (!id) return
        e.preventDefault()
        moveDown(id)
        return
    }

    // move up (⌘/Ctrl + ArrowUp)
    if (key === 'ArrowUp') {
        if (!id) return
        e.preventDefault()
        moveUp(id)
        return
    }
}
</script>

<template>
    <div class="relative h-screen overflow-y-hidden flex flex-col page-builder">
        <!-- Navbar -->
        <div
            class="h-11 bg-gray-100 dark:bg-gray-700 border-b flex items-center gap-1 md:gap-2 px-2 md:px-4 justify-between z-20">
            <div class="flex gap-1 md:gap-2 justify-start">
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
            <div class="flex gap-1 md:gap-2 justify-center">
                <SelectPage class="w-20 md:w-40" />
            </div>
            <div class="flex gap-1 md:gap-2 items-center justify-end">
                <button @click="exportBlocks"
                    class="rounded font-bold flex items-center justify-center p-2 hover:bg-primary hover:text-white"
                    title="Export">
                    <fg-loader v-if="isExporting" dots-move />
                    <i v-else class="icon bi-box-arrow-up"></i>

                </button>
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

                <button type="button" label="Save" class="btn btn-xs btn-primary" @click="submit">
                    <fg-icon icon="bi-floppy" />
                    <fg-loader v-if="form.processing" dots-scale />
                    <span v-else>Save</span>
                </button>
            </div>
        </div>

        <!-- Inspector -->
        <div class="fixed top-0 pt-11 bottom-0 start-0 w-80 border-e shadow flex flex-col bg-white dark:bg-gray-900 transition-transform z-10"
            :class="{ '-translate-x-full': !showInspector, 'translate-x-0': showInspector }">
            <div class="border-b bg-gray-50 dark:bg-gray-700">
                <div class="flex-space-2 px-3 py-2 font-semibold text-sm">
                    <div class="flex-1 flex-space-2 overflow-hidden">
                        <fg-icon icon="bi-list" />
                        <span>Blocks</span>
                    </div>
                    <button type="button" title="Collapse all" class="nav-link flex-space-1"
                        @click="EventBus.emit('collapseAll')">
                        <fg-icon icon="bi-arrows-collapse" />
                    </button>
                    <button type="button" title="expandAll" class="nav-link flex-space-1"
                        @click="EventBus.emit('expandAll')">
                        <fg-icon icon="bi-arrows-expand" />
                    </button>
                    <button type="button" title="Close" class="nav-link" @click="showInspector = false">
                        <fg-icon icon="bi-x-lg" />
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto" @click.stop="edit(undefined)">
                <inspector-draggable :blocks="form.blocks" :active-block="activeBlock" />
            </div>
        </div>

        <!-- Add block -->
        <add-block-panel :show="showAddBlock" @close="showAddBlock = false" :active-block="activeBlock" />

        <!-- Editor Panel -->

        <editor-panel :show="showEditor" :block="activeBlock" @close="showEditor = false"
            :key="activeBlock ? `editor-${activeBlock.id}` : uniqid('editor-')" />

        <!-- Main Content -->
        <div @click.stop="edit(undefined)" class="flex-1 overflow-y-auto relative pb-20"
            :class="{ 'md:ps-80': showInspector || showAddBlock, 'md:pe-72': showEditor }">
            <render-blocks :blocks="form.blocks" :active-block="activeBlock" />
            <block-appender v-show="!activeBlock" />
        </div>
        <div class="fixed bottom-0 z-30"
            :class="{ 'start-0': !showInspector, 'start-80': showInspector, 'end-0': !showEditor, 'end-72': showEditor }">
            <div class="flex-space-2">
                <button @click="showConsole = !showConsole" type="button"
                    class="btn btn-secondary w-8 h-8 flex items-center justify-center p-0 pill ms-2 mb-2">
                    <fg-icon :icon="showConsole ? 'bi-x-lg' : 'bi-terminal'" />
                </button>
                <button @click="resetBlocks" type="button"
                    class="btn btn-blue w-8 h-8 flex items-center justify-center p-0 pill ms-2 mb-2">
                    <fg-icon icon="bi-arrow-clockwise" />
                </button>
                <button @click="resetDefaultBlocks" type="button"
                    class="btn btn-red w-8 h-8 flex items-center justify-center p-0 pill ms-2 mb-2">
                    <fg-icon icon="bi-arrow-repeat" />
                </button>
            </div>

            <div v-show="showConsole" class="bg-gray-100 dark:bg-gray-700 border-t max-h-96 overflow-y-auto">
                <h3>Active block:</h3>
                <pre>{{ activeBlock }}</pre>
                <h3>Blocks:</h3>
                <pre>{{ form.blocks }}</pre>
            </div>
        </div>
    </div>
    <media-modal />
    <pattern-modal />
</template>
