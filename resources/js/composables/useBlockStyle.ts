export const useBlockStyle = (atts: Record<string, any>) => {
    return [
        ...(atts.bgImage ? [{ backgroundImage: `url(${atts.bgImage})` }] : []),
        ...(atts.style ? [atts.style] : []),
    ];
};
