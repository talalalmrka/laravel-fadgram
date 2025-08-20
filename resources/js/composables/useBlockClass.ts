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
export const useBlockClass = (atts: Record<string, any>) => {
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
        ],
        ...spacingClasses(atts),
    ];
    return classes.filter(
        (i) => i && i !== "" && i !== null && i !== undefined,
    );
};
