export const uniqid = (prefix: string | null = null) => {
    const uniq = Math.random().toString(36).slice(2, 9);
    return prefix ? `${prefix}${uniq}` : uniq;
};
