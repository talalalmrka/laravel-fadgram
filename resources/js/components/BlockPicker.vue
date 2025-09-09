<script setup lang="ts">
import {
    useBlockLabel,
    useBlocks,
    useInnerBlocks,
    usePatterns,
} from '@/composables/useBlocks';
import { Block, Pattern, Tab } from '@/types';
import EventBus from '@/types/event-bus';
import { computed, ref } from 'vue';
import {
    TabPanel
} from '@/components'
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Toast from "fadgram-ui/helpers/toast";

const props = defineProps<{
    activeBlock?: Block
}>()
const tabs: Tab[] = [
    {
        name: 'blocks',
        title: 'Blocks',
    },
    {
        name: 'patterns',
        title: 'patterns',
    },
]
// const initialBlocks: Block[] = props.activeBlock ? useInnerBlocks(props.activeBlock.type) : useBlocks()
const initialBlocks = computed(() => props.activeBlock ? useInnerBlocks(props.activeBlock.type) : useBlocks())
const search = ref('');
const blocks = computed(() => {
    const blockList = initialBlocks.value;
    if (search.value) {
        return blockList.filter((block: Block) =>
            block.label?.toLowerCase().includes(search.value.toLowerCase()) ||
            block.type.toLowerCase().includes(search.value.toLowerCase())
        ).sort((a: Block, b: Block) => (a.label || '').localeCompare(b.label || ''));
    }
    return blockList.sort((a: Block, b: Block) => (a.label || '').localeCompare(b.label || ''));
});
const activeBlockLabel = computed(() => props.activeBlock ? useBlockLabel(props.activeBlock.type) : 'The page');

const patterns = computed(() => {
    const items = usePatterns();
    if (search.value) {
        return items.filter((item: Pattern) =>
            item.name.toLowerCase().includes(search.value.toLowerCase())
            || item.block.label?.toLowerCase().includes(search.value.toLowerCase())
            || item.block.type.toLowerCase().includes(search.value.toLowerCase())
        ).sort((a: Pattern, b: Pattern) => (a.name || '').localeCompare(b.name || ''));
    }
    return items.sort((a: Pattern, b: Pattern) => (a.name || '').localeCompare(b.name || ''));
})
const add = (block: Block) => {
    EventBus.emit('add', block.type)
}
const patternToDelete = ref<Pattern | undefined>()


const exportPatterns = () => {
    const patternsToExport = patterns.value.map((pattern => ({
        name: pattern.name,
        icon: pattern.icon,
        description: pattern.description,
        block: pattern.block,
    })));
    const data = JSON.stringify(patternsToExport, null, 2);
    const blob = new Blob([data], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'patterns.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
const form = useForm({})
const removePattern = (pattern: Pattern) => {
    patternToDelete.value = pattern
    form.post(route('patterns.destroy', { pattern: pattern.id }), {
        preserveScroll: true,
        showProgress: false,
        onSuccess: (page) => {
            // toast success
            const flashes = page.props.flash;
            if (flashes && Object.prototype.hasOwnProperty.call(flashes, 'delete')) {
                const successMessage = (flashes as Record<string, string | undefined>)['delete']
                if (successMessage) {
                    Toast.success(successMessage, 'bottom-start');
                }
            }

            // Toast error
            const errs = page.props.errors;
            if (errs && !Object.prototype.hasOwnProperty.call(errs, 'delete')) {
                const errorMessage = errs['delete'];
                if (errorMessage) {
                    Toast.error(errorMessage, 'bottom-start');
                }
            }

        },
    });
}
</script>

<template>
    <div class="px-3 py-4 flex-1 overflow-y-auto">
        <fg-input type="search" v-model="search" startIcon="bi-search" placeholder="Search" size="sm" />
        <tab-panel :tabs="tabs">
            <template #blocks>
                <div v-if="blocks.length" class="grid grid-cols-3 py-3">
                    <div @click="add(block)" v-for="block in blocks"
                        class="col px-1 py-3 hover:bg-primary-100 hover:text-primary cursor-pointer">
                        <div class="text-center">
                            <fg-icon :icon="block.icon" class="text-2xl" />
                        </div>
                        <div class="text-center text-sm">
                            {{ block.label }}
                        </div>
                    </div>
                </div>
                <fg-alert v-else size="sm" :content="`No available blocks for: ${activeBlockLabel}`" soft
                    class="mt-4" />
            </template>
            <template #patterns>
                <div class="px-3 py-2">
                    <button @click="exportPatterns" title="Export" type="button" class="btn btn-xs btn-outline-primary">
                        <fg-icon icon="bi-box-arrow-up" />
                        <span>Export</span>
                    </button>
                </div>

                <div v-if="patterns.length" class="flex flex-col divide-y">
                    <div v-for="pattern in patterns" @click="EventBus.emit('addPattern', pattern)"
                        class="px-3 py-2 text-sm cursor-pointer flex-space-2 justify-between hover:bg-primary-50 hover:text-primary">
                        <div class="flex-space-2 flex-1">
                            <fg-icon :icon="pattern.icon" />
                            <span>{{ pattern.name }}</span>
                        </div>
                        <button type="button" title="Delete" @click.stop="removePattern(pattern)" class="icon-link">
                            <fg-loader v-if="form.processing && patternToDelete && pattern.id === patternToDelete.id"
                                dots-move />
                            <fg-icon v-else icon="bi-trash" />
                        </button>
                    </div>

                </div>
                <fg-alert v-else size="sm" :content="`No available patterns for: ${activeBlockLabel}`" soft
                    class="mt-4" />
            </template>
        </tab-panel>
    </div>
</template>
