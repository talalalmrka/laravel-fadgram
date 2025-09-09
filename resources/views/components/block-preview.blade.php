<x-app-layout :title="data_get($block, 'type')">
    {!! block($block) !!}
    <div x-data="{ console: false }" class="fixed bottom-0 z-30 inset-x-0">
        <div class="flex-space-2">
            <button x-on:click="console = !console" type="button"
                class="btn btn-secondary w-8 h-8 flex items-center justify-center p-0 pill ms-2 mb-2">
                <i class="icon" :class="{ 'bi-x-lg': console, 'bi-terminal': !console }"></i>
            </button>
        </div>

        <div x-collapse x-show="console" class="bg-gray-100 dark:bg-gray-700 border-t max-h-96 overflow-y-auto">
            @dump($block)
        </div>
    </div>
</x-app-layout>
