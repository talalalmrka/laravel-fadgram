import { OptionType } from "@/types";

export const useLayoutOptions = (): OptionType[] => {
    return [
        {
            label: "Grid",
            value: "grid",
        },
        {
            label: "Carousel",
            value: "carousel",
        },
    ];
};
