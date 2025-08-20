function AlpineTabsPlugin(Alpine) {
    Alpine.directive('tabs', (element) => {
        let data = Alpine.$data(element) || {};
        let activeTab = element.getAttribute('data-active');
        if (activeTab === null) {
            const tabElements = element.querySelectorAll('[x-tab]');
            if (tabElements.length > 0) {
                const firstTabName = tabElements[0].getAttribute('x-tab');
                activeTab = firstTabName;
            }
        }
        data.activeTab = activeTab;
        Alpine.$data(element, data);
    });

    // x-tabs-header: Styles the header container
    Alpine.directive('tabs-header', (element) => {
        element.classList.add('flex-space-4', 'border-b', 'border-gray-200', 'dark:border-gray-600');
    });

    // x-tab: Manages tab buttons with click events and active styling
    Alpine.directive('tab', (element, { expression }, { effect, evaluateLater }) => {
        const tabName = expression;
        element.classList.add('py-2','border-b-2','border-transparent','font-medium','text-sm','cursor-pointer');
        const getActiveTab = evaluateLater('activeTab');

        element.addEventListener('click', () => {
            Alpine.$data(element).activeTab = tabName;
        });

        effect(() => {
            getActiveTab((activeTab) => {
                if (activeTab === tabName) {
                    element.classList.remove('border-transparent');
                    element.classList.add('border-primary');
                } else {
                    element.classList.remove('border-primary');
                    element.classList.add('border-transparent');
                }
            });
        });
    });

    // x-tabs-content: Styles the content container
    Alpine.directive('tabs-content', (element) => {
        element.classList.add('py-3');
    });

    // x-tab-panel: Controls visibility of content panels
    Alpine.directive('tab-panel', (element, { expression }, { effect, evaluateLater }) => {
        const tabName = expression;
        element.classList.add('hidden');
        const getActiveTab = evaluateLater('activeTab');

        effect(() => {
            getActiveTab((activeTab) => {
                if (activeTab === tabName) {
                    element.classList.remove('hidden');
                } else {
                    element.classList.add('hidden');
                }
            });
        });
    });
}

// Register the plugin with Alpine.js
document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(AlpineTabsPlugin);
});
