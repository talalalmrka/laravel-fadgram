import { OptionType } from "@/types";

export const useLinkTypeOptions = (): OptionType[] => {
    return [
        {
            label: "default",
            value: "",
        },
        {
            label: "link",
            value: "link",
        },
        {
            label: "underline",
            value: "link-underline",
        },
        {
            label: "link & hover underline",
            value: "link hover:link-underline",
        },
        {
            label: "hover underline",
            value: "hover:link-underline",
        },
    ];
};
