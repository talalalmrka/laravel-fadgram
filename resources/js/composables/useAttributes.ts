import { BlockType } from "@/types";
import { computed } from "vue";
import { useBlockDefaults } from "./useBlocks";
import { data_get, data_set } from "@/helpers";
import _ from "lodash";

export const useAttributes = (block: BlockType) => {
    const defaults = useBlockDefaults(block.type);
    return computed({
        get() {
            return block.attributes ?? {};
        },
        set(val) {
            block.attributes = val;
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
