import { flat, isFlex } from "@/helpers";
import { unref } from "vue";

export const spacingClasses = (atts: Record<string, any>) => {
    let classes: string[] = [];
    const margin = unref(atts).margin ?? {};
    Object.values(margin).forEach((b) => {
        if (typeof b === "object") {
            Object.values(b ?? {}).forEach((c) => {
                if (c) {
                    classes.push(c);
                }
            });
        }
    });
    const padding = atts.padding ?? {};
    Object.values(padding).forEach((d) => {
        if (typeof d === "object") {
            Object.values(d ?? {}).forEach((e) => {
                if (e) {
                    classes.push(e);
                }
            });
        }
    });
    return classes;
};

export const positionClasses = (atts: Record<string, any>): string[] => {
    const position = unref(atts).position;
    return (
        (Object.values(
            position && typeof position === "object" ? position : {},
        ).filter((i) => i && i !== "" && typeof i === "string") as string[]) ??
        []
    );
};
export const displayClasses = (atts: Record<string, any>): string[] => {
    const display = unref(atts).display;
    return (
        (Object.values(
            display && typeof display === "object" ? display : {},
        ).filter((i) => i && i !== "" && typeof i === "string") as string[]) ??
        []
    );
};
/* export const useBlockClasssss = (atts: Record<string, any>) => {
    const a = unref(atts) ?? {};
    const classes = [
        ...[
            a.textColor,
            a.bgColor,
            a.bgSize,
            a.bgPosition,
            a.bgAttachment,
            a.fontSize,
            a.fontWeight,
            a.fontStyle,
            a.textTransform,
            a.textAlign,
            a.className,
            a.borderSize,
            a.borderStyle,
            a.borderColor,
            a.borderRadius,
            a.shadowSize,
            a.shadowColor,
            a.position,
        ],
        ...spacingClasses(atts),
        ...positionClasses(atts),
        ...displayClasses(atts),
    ];
    return classes.filter(
        (i) => i && i !== "" && i !== null && i !== undefined,
    );
}; */

export const useBlockClass = (atts: Record<string, any>) => {
    const a = unref(atts) ?? {};
    const ops = [
        a.textColor,
        a.fontSize,
        a.fontWeight,
        a.fontStyle,
        a.textTransform,
        a.textAlign,
        a.bgColor,
        a.bgSize,
        a.bgPosition,
        a.bgAttachment,
        a.margin,
        a.padding,
        a.borderSize,
        a.borderStyle,
        a.borderColor,
        a.borderRadius,
        a.shadowSize,
        a.shadowColor,
        a.position,
        a.display,
        a.inset,
        a.zIndex,
        a.className,
    ];
    if (isFlex(atts)) {
        ops.push(...[a.flexDirection, a.alignItems, a.justifyContent]);
    }
    return flat(ops);
};
