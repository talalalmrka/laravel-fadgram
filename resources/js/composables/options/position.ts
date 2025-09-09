import { OptionType } from "@/types";

export const usePositionOptions = (): Record<string, OptionType[]> => {
    return {
        sm: [
            {
                label: "none",
                value: "",
            },
            {
                label: "static",
                value: "static",
            },
            {
                label: "fixed",
                value: "fixed",
            },
            {
                label: "absolute",
                value: "absolute",
            },
            {
                label: "relative",
                value: "relative",
            },
            {
                label: "sticky",
                value: "sticky",
            },
        ],
        md: [
            {
                label: "none",
                value: "",
            },
            {
                label: "static",
                value: "md:static",
            },
            {
                label: "fixed",
                value: "md:fixed",
            },
            {
                label: "absolute",
                value: "md:absolute",
            },
            {
                label: "relative",
                value: "md:relative",
            },
            {
                label: "sticky",
                value: "md:sticky",
            },
        ],
        lg: [
            {
                label: "none",
                value: "",
            },
            {
                label: "static",
                value: "lg:static",
            },
            {
                label: "fixed",
                value: "lg:fixed",
            },
            {
                label: "absolute",
                value: "lg:absolute",
            },
            {
                label: "relative",
                value: "lg:relative",
            },
            {
                label: "sticky",
                value: "lg:sticky",
            },
        ],
        xl: [
            {
                label: "none",
                value: "",
            },
            {
                label: "static",
                value: "xl:static",
            },
            {
                label: "fixed",
                value: "xl:fixed",
            },
            {
                label: "absolute",
                value: "xl:absolute",
            },
            {
                label: "relative",
                value: "xl:relative",
            },
            {
                label: "sticky",
                value: "xl:sticky",
            },
        ],
    };
};
