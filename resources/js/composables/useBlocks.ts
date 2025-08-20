import { BlockFeatures, BlockType } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { uniqid } from "../helpers/uniqid";

export const useBlocks = (): BlockType[] => {
    const page = usePage<{ props: { registeredBlocks: BlockType[] } }>();
    return (page.props.registeredBlocks as BlockType[]) ?? [];
};

export const useBlockTypes = () => {
    const blocks = useBlocks();
    return blocks.map((item) => item.type);
};
export const useInnerBlocks = (type: string): BlockType[] => {
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
export const useBlock = (type: string): BlockType | undefined => {
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
export const useBlockDefaults = (type: string): Partial<BlockType> => {
    const block = useBlock(type);
    const defaults: Record<string, any> = {};
    if (block && block.attributes) {
        for (let key in block.attributes) {
            defaults[key] = block.attributes?.[key].default;
        }
    }
    return defaults;
};
// Precomputed valid keys for runtime validation
const BLOCK_FEATURE_KEYS: (keyof BlockFeatures)[] = [
    "typography",
    "bgColor",
    "bgImage",
    "margin",
    "padding",
    "border",
    "shadow",
    "htmlAnchor",
    "className",
    "style",
];

export const useBlockFeatures = (type: string): BlockFeatures => {
    const block = useBlock(type);
    const features: BlockFeatures = {
        typography: false,
        bgColor: false,
        bgImage: false,
        margin: false,
        padding: false,
        border: false,
        shadow: false,
        htmlAnchor: false,
        className: false,
        style: false,
    };

    // Use Set for O(1) lookups
    const validKeysSet = new Set(BLOCK_FEATURE_KEYS);
    const blockFeatures = block?.features ?? [];
    for (const f of blockFeatures) {
        if (validKeysSet.has(f as keyof BlockFeatures)) {
            features[f as keyof BlockFeatures] = true;
        }
    }
    return features;
};
export const resolveBlock = (
    type: string,
    data?: Partial<BlockType>,
): BlockType | undefined => {
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
        } as BlockType;
    } else {
        return undefined;
    }
};

export const useHasChildren = (type: string) => {
    const block = useBlock(type);
    return block && block.children;
};

export const useBlockAllowed = (type: string, parent: string | undefined) => {
    return parent ? useInnerTypes(parent).includes(type) : true;
};
/* export const useNewBlock = (type: string, data = {}): BlockType => {
    const defaults = useBlockDefaults(type);

    return resolveBlock({
        type: type,
        id: uniqid("block-"),
        ...defaults,
        ...data,
    });
}; */
