import { Block, Pattern } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { uniqid } from "../helpers/uniqid";
import { data_get } from "@/helpers";

export const useBlocks = (): Block[] => {
    const page = usePage<{ props: { registeredBlocks: Block[] } }>();
    return (page.props.registeredBlocks as Block[]) ?? [];
};

export const useBlockTypes = () => {
    const blocks = useBlocks();
    return blocks.map((item) => item.type);
};
export const useInnerBlocks = (type: string): Block[] => {
    const block = useBlock(type);
    if (block) {
        const blocks = useBlocks();
        if (block.inner === "all") {
            return blocks;
        }
        const inners =
            (block.inner && Array.isArray(block.inner)
                ? block.inner
                : [block.inner]) ?? [];
        return useBlocks().filter((item) => inners.includes(item.type));
    } else {
        return [];
    }
};
export const useInnerTypes = (type: string): string[] => {
    const innerBlocks = useInnerBlocks(type);
    return innerBlocks.map((block) => block.type);
};
export const useBlock = (type: string): Block | undefined => {
    const blocks = useBlocks();
    return blocks.find((b) => b.type === type);
};
export const useBlockIcon = (type: string | undefined) => {
    return type ? useBlock(type)?.icon : undefined;
};
export const useBlockLabel = (type: string | undefined) => {
    if (type === undefined) return undefined;
    const block = useBlock(type);
    return block?.label;
};
export const useBlockDefaults = (type: string): Partial<Block> => {
    const block = useBlock(type);
    const defaults: Record<string, any> = {};
    if (block && block.attributes) {
        for (let key in block.attributes) {
            defaults[key] = block.attributes?.[key].default;
        }
    }
    return defaults;
};

export const resolveBlock = (
    type: string,
    data?: Partial<Block>,
): Block | undefined => {
    const block = useBlock(type);
    if (block) {
        const defaults = useBlockDefaults(type);
        const resolvedBlock = {
            type: type,
            id: uniqid("block-"),
            attributes: defaults,
            ...data,
        };
        const resolvedChildren = Array.isArray(block.children)
            ? block.children
                  .filter((child) => child !== undefined)
                  .map((item) => resolveBlock(item.type, item))
            : undefined;

        return {
            ...resolvedBlock,
            ...(resolvedChildren !== undefined
                ? { children: resolvedChildren }
                : {}),
        } as Block;
    } else {
        return undefined;
    }
};

export const useHasChildren = (type: string) => {
    const block = useBlock(type);
    return block && Array.isArray(block.children);
};

export const useBlockAllowed = (type: string, parent: string | undefined) => {
    return parent ? useInnerTypes(parent).includes(type) : true;
};
export const resolveBlocks = (data: Partial<Block>[]): Block[] => {
    return data.map((item) => {
        const block: Block = {
            ...item,
            ...{
                id: uniqid("block-"),
            },
        } as Block;
        const children = data_get(item, "children");
        if (children && Array.isArray(children)) {
            block.children = resolveBlocks(children);
        }
        return block;
    });
};
export const useBlockFeatures = (type: string): Record<string, boolean> => {
    const block = useBlock(type);
    const features: Record<string, boolean> = {};
    if (block) {
        (block.features ?? []).forEach((feature) => (features[feature] = true));
    }
    return features;
};

export const usePatterns = (): Pattern[] => {
    const page = usePage<{ props: { patterns: Pattern[] } }>();
    return (page.props.patterns as Pattern[]) ?? [];
};
