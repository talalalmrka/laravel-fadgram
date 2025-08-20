import { OptionType } from "@/types";

export const useColors = () => {
    return [
        "",
        "primary",
        "secondary",
        "white",
        "black",
        "light",
        "dark",
        "red",
        "orange",
        "amber",
        "yellow",
        "lime",
        "green",
        "emerald",
        "teal",
        "cyan",
        "sky",
        "blue",
        "indigo",
        "violet",
        "purple",
        "fuchsia",
        "pink",
        "rose",
        "slate",
        "zinc",
        "neutral",
        "stone",
    ];
};
export const useColorOptions = (): OptionType[] => {
    return useColors().map((color) => ({
        label: color !== "" ? color : "none",
        value: color,
    }));
};
