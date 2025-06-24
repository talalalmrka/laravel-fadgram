import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import path from "path";
import tailwindcss from "@tailwindcss/vite";
import { resolve } from "node:path";

import { defineConfig } from "vite";
export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/preview.js",
                "resources/js/inertia.ts",
            ],
            ssr: "resources/js/ssr.ts",
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js"),
            "ziggy-js": resolve(__dirname, "vendor/tightenco/ziggy"),
        },
    },
    server: {
        cors: true,
        watch: {
            interval: 1000,
        },
    },
});
