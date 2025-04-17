import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue, route } from 'ziggy-js';
//import route from 'ziggy-js'

createInertiaApp({
  resolve: name =>
    resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),

  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, { route })
      .mount(el)
  },
})
