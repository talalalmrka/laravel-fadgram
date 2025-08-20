import { range } from "@/helpers";
import { OptionType } from "@/types";

export const useHeadingTagOptions = (): OptionType[] => {
    return range(1, 6).map((i) => ({
        label: `h${i}`,
        value: `h${i}`,
    }));
};
