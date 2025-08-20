import "../css/inertia.css";
// import 'jodit/build/jodit.min.css'

// import 'fadgram-vue/dist/fadgram-vue.css'
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import type { DefineComponent } from "vue";
import { createApp, h } from "vue";
import { ZiggyVue } from "ziggy-js";
import { initializeTheme } from "./composables/useAppearance";
import { useMessages } from './composables/useMessages';
import FadgramVue from 'fadgram-vue'
import JoditVue from 'jodit-vue'
import Dump from "./components/Dump.vue";

;(window as any).Alpine = Alpine
Alpine.plugin(collapse)
Alpine.start()

// Extend ImportMeta interface for Vite...
declare module "vite/client" {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });
        vueApp.use(plugin);
        vueApp.use(ZiggyVue);
        vueApp.use(FadgramVue);
        vueApp.use(JoditVue);
        vueApp.component('Dump', Dump)
        // Add global helpers
        const { getErrorMessage, getFlashMessage } = useMessages();
        vueApp.config.globalProperties.$getErrorMessage = getErrorMessage;
        vueApp.config.globalProperties.$getFlashMessage = getFlashMessage;
        vueApp.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});

// This will set light / dark mode on page load...
initializeTheme();
