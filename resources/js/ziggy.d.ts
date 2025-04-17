import { Router } from 'ziggy-js';

declare global {
    interface Window {
        Ziggy: Router;
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof Router;
    }
}
