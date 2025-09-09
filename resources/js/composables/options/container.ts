import { OptionType } from "@/types";

export const useContainerTypeOptions = (): OptionType[] => {
    const types = [
        "",
        "container",
        "container-fluid",
        "grid",
        "col",
        "card",
        "card-header",
        "card-body",
        "card-footer",
        "list-group",
        "list-group-item",
    ];
    return [
        {
            label: "No class",
            value: "",
        },
        {
            label: "Container (default)",
            value: "container",
        },
        {
            label: "container-fluid",
            value: "container-fluid",
        },
        {
            label: "grid",
            value: "grid",
        },
        {
            label: "col",
            value: "col",
        },
        {
            label: "card",
            value: "card",
        },
        {
            label: "card-header",
            value: "card-header",
        },
        {
            label: "card-body",
            value: "card-body",
        },
        {
            label: "card-footer",
            value: "card-footer",
        },
        {
            label: "list-group",
            value: "list-group",
        },
        {
            label: "list-group-item",
            value: "list-group-item",
        },
    ];
};

export const useGridColsOptions = (): Record<string, OptionType[]> => {
    return {
        sm: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "grid-cols-1",
            },
            {
                label: "2",
                value: "grid-cols-2",
            },
            {
                label: "3",
                value: "grid-cols-3",
            },
            {
                label: "4",
                value: "grid-cols-4",
            },
            {
                label: "5",
                value: "grid-cols-5",
            },
            {
                label: "6",
                value: "grid-cols-6",
            },
            {
                label: "7",
                value: "grid-cols-7",
            },
            {
                label: "8",
                value: "grid-cols-8",
            },
            {
                label: "9",
                value: "grid-cols-9",
            },
            {
                label: "10",
                value: "grid-cols-10",
            },
        ],
        md: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "md:grid-cols-1",
            },
            {
                label: "2",
                value: "md:grid-cols-2",
            },
            {
                label: "3",
                value: "md:grid-cols-3",
            },
            {
                label: "4",
                value: "md:grid-cols-4",
            },
            {
                label: "5",
                value: "md:grid-cols-5",
            },
            {
                label: "6",
                value: "md:grid-cols-6",
            },
            {
                label: "7",
                value: "md:grid-cols-7",
            },
            {
                label: "8",
                value: "md:grid-cols-8",
            },
            {
                label: "9",
                value: "md:grid-cols-9",
            },
            {
                label: "10",
                value: "md:grid-cols-10",
            },
        ],
        lg: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "lg:grid-cols-1",
            },
            {
                label: "2",
                value: "lg:grid-cols-2",
            },
            {
                label: "3",
                value: "lg:grid-cols-3",
            },
            {
                label: "4",
                value: "lg:grid-cols-4",
            },
            {
                label: "5",
                value: "lg:grid-cols-5",
            },
            {
                label: "6",
                value: "lg:grid-cols-6",
            },
            {
                label: "7",
                value: "lg:grid-cols-7",
            },
            {
                label: "8",
                value: "lg:grid-cols-8",
            },
            {
                label: "9",
                value: "lg:grid-cols-9",
            },
            {
                label: "10",
                value: "lg:grid-cols-10",
            },
        ],
        xl: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "xl:grid-cols-1",
            },
            {
                label: "2",
                value: "xl:grid-cols-2",
            },
            {
                label: "3",
                value: "xl:grid-cols-3",
            },
            {
                label: "4",
                value: "xl:grid-cols-4",
            },
            {
                label: "5",
                value: "xl:grid-cols-5",
            },
            {
                label: "6",
                value: "xl:grid-cols-6",
            },
            {
                label: "7",
                value: "xl:grid-cols-7",
            },
            {
                label: "8",
                value: "xl:grid-cols-8",
            },
            {
                label: "9",
                value: "xl:grid-cols-9",
            },
            {
                label: "10",
                value: "xl:grid-cols-10",
            },
        ],
    };
};
export const useGapOptions = (): Record<string, OptionType[]> => {
    return {
        sm: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "gap-1",
            },
            {
                label: "2",
                value: "gap-2",
            },
            {
                label: "3",
                value: "gap-3",
            },
            {
                label: "4",
                value: "gap-4",
            },
            {
                label: "5",
                value: "gap-5",
            },
            {
                label: "6",
                value: "gap-6",
            },
            {
                label: "7",
                value: "gap-7",
            },
            {
                label: "8",
                value: "gap-8",
            },
            {
                label: "9",
                value: "gap-9",
            },
            {
                label: "10",
                value: "gap-10",
            },
        ],
        md: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "md:gap-1",
            },
            {
                label: "2",
                value: "md:gap-2",
            },
            {
                label: "3",
                value: "md:gap-3",
            },
            {
                label: "4",
                value: "md:gap-4",
            },
            {
                label: "5",
                value: "md:gap-5",
            },
            {
                label: "6",
                value: "md:gap-6",
            },
            {
                label: "7",
                value: "md:gap-7",
            },
            {
                label: "8",
                value: "md:gap-8",
            },
            {
                label: "9",
                value: "md:gap-9",
            },
            {
                label: "10",
                value: "md:gap-10",
            },
        ],
        lg: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "lg:gap-1",
            },
            {
                label: "2",
                value: "lg:gap-2",
            },
            {
                label: "3",
                value: "lg:gap-3",
            },
            {
                label: "4",
                value: "lg:gap-4",
            },
            {
                label: "5",
                value: "lg:gap-5",
            },
            {
                label: "6",
                value: "lg:gap-6",
            },
            {
                label: "7",
                value: "lg:gap-7",
            },
            {
                label: "8",
                value: "lg:gap-8",
            },
            {
                label: "9",
                value: "lg:gap-9",
            },
            {
                label: "10",
                value: "lg:gap-10",
            },
        ],
        xl: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "xl:gap-1",
            },
            {
                label: "2",
                value: "xl:gap-2",
            },
            {
                label: "3",
                value: "xl:gap-3",
            },
            {
                label: "4",
                value: "xl:gap-4",
            },
            {
                label: "5",
                value: "xl:gap-5",
            },
            {
                label: "6",
                value: "xl:gap-6",
            },
            {
                label: "7",
                value: "xl:gap-7",
            },
            {
                label: "8",
                value: "xl:gap-8",
            },
            {
                label: "9",
                value: "xl:gap-9",
            },
            {
                label: "10",
                value: "xl:gap-10",
            },
        ],
    };
};

export const useColspanOptions = (): Record<string, OptionType[]> => {
    return {
        sm: [
            {
                label: "none",
                value: "",
            },
            {
                label: "1",
                value: "col-span-1",
            },
            {
                label: "2",
                value: "col-span-2",
            },
            {
                label: "3",
                value: "col-span-3",
            },
            {
                label: "4",
                value: "col-span-4",
            },
            {
                label: "5",
                value: "col-span-5",
            },
            {
                label: "6",
                value: "col-span-6",
            },
            {
                label: "7",
                value: "col-span-7",
            },
            {
                label: "8",
                value: "col-span-8",
            },
            {
                label: "9",
                value: "col-span-9",
            },
            {
                label: "10",
                value: "col-span-10",
            },
        ],
        md: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "md:col-span-1",
            },
            {
                label: "2",
                value: "md:col-span-2",
            },
            {
                label: "3",
                value: "md:col-span-3",
            },
            {
                label: "4",
                value: "md:col-span-4",
            },
            {
                label: "5",
                value: "md:col-span-5",
            },
            {
                label: "6",
                value: "md:col-span-6",
            },
            {
                label: "7",
                value: "md:col-span-7",
            },
            {
                label: "8",
                value: "md:col-span-8",
            },
            {
                label: "9",
                value: "md:col-span-9",
            },
            {
                label: "10",
                value: "md:col-span-10",
            },
        ],
        lg: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "lg:col-span-1",
            },
            {
                label: "2",
                value: "lg:col-span-2",
            },
            {
                label: "3",
                value: "lg:col-span-3",
            },
            {
                label: "4",
                value: "lg:col-span-4",
            },
            {
                label: "5",
                value: "lg:col-span-5",
            },
            {
                label: "6",
                value: "lg:col-span-6",
            },
            {
                label: "7",
                value: "lg:col-span-7",
            },
            {
                label: "8",
                value: "lg:col-span-8",
            },
            {
                label: "9",
                value: "lg:col-span-9",
            },
            {
                label: "10",
                value: "lg:col-span-10",
            },
        ],
        xl: [
            {
                label: "none",
                value: undefined,
            },
            {
                label: "1",
                value: "xl:col-span-1",
            },
            {
                label: "2",
                value: "xl:col-span-2",
            },
            {
                label: "3",
                value: "xl:col-span-3",
            },
            {
                label: "4",
                value: "xl:col-span-4",
            },
            {
                label: "5",
                value: "xl:col-span-5",
            },
            {
                label: "6",
                value: "xl:col-span-6",
            },
            {
                label: "7",
                value: "xl:col-span-7",
            },
            {
                label: "8",
                value: "xl:col-span-8",
            },
            {
                label: "9",
                value: "xl:col-span-9",
            },
            {
                label: "10",
                value: "xl:col-span-10",
            },
        ],
    };
};
