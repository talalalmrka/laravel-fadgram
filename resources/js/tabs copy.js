function AlpineTabsPlugin(Alpine) {
    // Define the x-tab directive
    Alpine.directive('tab', (element, { expression }, { effect, evaluateLater }) => {
      const tabName = expression; // e.g., "tab1"
      const getActiveTab = evaluateLater('activeTab');

      // Add click event to set activeTab
      element.addEventListener('click', () => {
        Alpine.$data(element).activeTab = tabName;
      });

      // Watch activeTab and toggle active-tab class
      effect(() => {
        getActiveTab((activeTab) => {
          if (activeTab === tabName) {
            element.classList.add('active-tab');
          } else {
            element.classList.remove('active-tab');
          }
        });
      });
    });

    // Define the x-tab-panel directive
    Alpine.directive('tab-panel', (element, { expression }, { effect, evaluateLater }) => {
      const tabName = expression; // e.g., "tab1"
      const getActiveTab = evaluateLater('activeTab');

      // Watch activeTab and toggle visibility with Tailwind's hidden class
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
