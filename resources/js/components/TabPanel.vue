    <script setup lang="ts">
    import { Tab } from '@/types/tab'
    import { ref, computed, watch } from 'vue'
    const props = withDefaults(defineProps<{
        tabs: Tab[];
        initialTab?: string | null;
        activeTab?: string | null;
        headClass?: string
        contentClass?: string
        onSelect?: (name: string) => void;
    }>(), {
        tabs: () => ([]),
        initialTab: null,
        activeTab: null,
        onSelect: () => { },
    })


    const emit = defineEmits(['update:activeTab', 'tab-change'])

    // Active tab handling
    const internalActiveTab = ref<string | null>(props.initialTab || props.tabs[0].name)
    const isControlled = computed(() => props.activeTab !== null)

    const activeTabName = computed({
        get: () => isControlled.value ? props.activeTab : internalActiveTab.value,
        set: (value) => {
            if (!isControlled.value) {
                internalActiveTab.value = value
            }
            emit('update:activeTab', value)
        }
    })

    // Tab selection handler
    function selectTab(tabName: string) {
        const tab = props.tabs.find(t => t.name === tabName)
        if (!tab || tab.disabled) return

        activeTabName.value = tabName
        props.onSelect(tabName)
        emit('tab-change', tabName)
    }

    // Initialize active tab
    watch(() => props.tabs, (newTabs) => {
        if (newTabs.length > 0 && !activeTabName.value) {
            selectTab(newTabs[0].name)
        }
    }, { immediate: true })
</script>
  <template>
    <div class="flex flex-col">
        <!-- Tab Navigation -->
        <div class="flex justify-between border-b" :class="headClass">
            <button v-for="tab in tabs" :key="tab.name" @click="selectTab(tab.name)"
                class="px-3 py-2 text-sm font-medium transition-colors duration-200 ease-in-out border-b-2" :class="{
                    'border-transparent': activeTabName !== tab.name,
                    'border-primary': activeTabName === tab.name
                }">
                {{ tab.title }}
            </button>
        </div>

        <!-- Tab Content -->
        <div :class="contentClass">
            <slot :name="activeTabName"></slot>
        </div>
    </div>
</template>
