import { Block } from "@/types";
import { defineAsyncComponent } from "vue";

/**
 * Dynamically load a component from a path.
 * Works without preloading modules.
 *
 * @param path - Component path (relative to this file or an alias like @/components)
 */
export function useComponent(path: string) {
    return defineAsyncComponent(() => import(/* @vite-ignore */ path));
}

export function useBlockEdit(block?: Block) {
    if (block) {
        const path = `@/blocks/${block.type}/Edit.vue`;
        return useComponent(path);
    } else {
        return undefined;
    }
}

export function useBlockRender(block?: Block) {
    if (block) {
        const path = `@/blocks/${block.type}/Render.vue`;
        return useComponent(path);
    } else {
        return undefined;
    }
}
