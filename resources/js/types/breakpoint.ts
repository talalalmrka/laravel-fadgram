export type Breakpoint = "sm" | "md" | "lg" | "xl";
export type Side = "top" | "bottom" | "start" | "end";
export type Spacing = Record<
    Breakpoint,
    Record<Side, string | null | undefined>
>;
/* export interface Spacing {
    sm: { top: string; start: string; end: string; bottom: string };
    md: { top: string; start: string; end: string; bottom: string };
    lg: { top: string; start: string; end: string; bottom: string };
    xl: { top: string; start: string; end: string; bottom: string };
} */
