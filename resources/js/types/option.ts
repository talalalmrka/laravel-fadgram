// types/option.ts
/* export interface OptionType {
    label: string
    value: string
} */

export interface OptionType {
    label?: string;
    icon?: string;
    value: any;
    disabled?: boolean;
}
