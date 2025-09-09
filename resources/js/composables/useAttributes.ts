import { Block } from "@/types";
import { computed, ComputedRef } from "vue";
import { data_get, data_set } from "@/helpers";

export const useAttributes = (block: Block): Record<string, any> => {
    return computed({
        get() {
            return block.attributes ?? {};
        },
        set(val) {
            block.attributes = val;
        },
    });
};

export const useChildren = (block: Block) => {
    return computed({
        get() {
            return block.children ?? [];
        },
        set(val) {
            block.children = val;
        },
    });
};
export const useAttribute = (
    object: any,
    path: string | string[],
    defaultValue?: any,
) => {
    return computed({
        get() {
            return data_get(object, path, defaultValue);
        },
        set(val) {
            data_set(object, path, val);
        },
    });
};
