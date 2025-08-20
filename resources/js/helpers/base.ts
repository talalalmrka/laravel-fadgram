/**
 * Retrieve nested values from an object using dot-notation or array path.
 * Similar to Laravel's data_get helper.
 *
 * @param object - The object to search in
 * @param path - String path (dot-separated) or array path
 * @param defaultValue - Value to return if path not found
 * @returns Value at path, default value, or undefined
 */
export function data_get<T = any>(
    object: any,
    path: string | string[],
    defaultValue?: T,
): T | undefined {
    if (object === null || object === undefined) {
        return defaultValue;
    }

    const pathArray = Array.isArray(path) ? path : path.split(".");
    let current: any = object;

    for (const segment of pathArray) {
        if (current === null || current === undefined) {
            return defaultValue;
        }

        // Handle Map and Set special cases
        if (current instanceof Map) {
            current = current.get(segment);
            continue;
        }

        if (current instanceof Set) {
            current = current.has(segment) ? segment : undefined;
            continue;
        }

        // Handle objects and arrays
        if (typeof current === "object" || typeof current === "function") {
            if (!(segment in current)) {
                return defaultValue;
            }
        }

        current = current[segment];
    }

    return current !== undefined ? current : defaultValue;
}

/**
 * Set a value at a nested path within an object, creating any missing objects or arrays as needed.
 * Similar to Laravel's data_set helper.
 *
 * @param object - The object to set the value in
 * @param path - String path (dot-separated) or array path
 * @param value - Value to set at the path
 * @returns The original object
 */
export function data_set(
    object: object,
    path: string | string[],
    value: any,
): any {
    const pathArray = Array.isArray(path) ? path : path.split(".");
    let current: any = object;

    for (let i = 0; i < pathArray.length; i++) {
        const segment = pathArray[i];
        const isLast = i === pathArray.length - 1;

        if (isLast) {
            if (current instanceof Map) {
                current.set(segment, value);
            } else if (current instanceof Set) {
                current.add(value);
            } else {
                current[segment] = value;
            }
            return object;
        }

        let next: any;
        if (current instanceof Map) {
            next = current.get(segment);
        } else if (current instanceof Set) {
            if (isArrayIndex(segment)) {
                const index = parseInt(segment, 10);
                let count = 0;
                for (const item of current) {
                    if (count === index) {
                        next = item;
                        break;
                    }
                    count++;
                }
            }
        } else {
            next = current[segment];
        }

        if (
            next !== undefined &&
            (next === null ||
                (typeof next !== "object" && typeof next !== "function"))
        ) {
            break;
        }

        if (next === undefined) {
            const nextSegment = pathArray[i + 1];
            next = isArrayIndex(nextSegment) ? [] : {};

            if (current instanceof Map) {
                current.set(segment, next);
            } else if (current instanceof Set) {
                break;
            } else {
                current[segment] = next;
            }
        }

        current = next;
    }

    return object;
}

function isArrayIndex(key: string): boolean {
    const num = Number(key);
    if (isNaN(num) || num < 0 || num > 4294967294) {
        return false;
    }
    return String(num) === key;
}

export const range = (start: number, end: number, step = 1) =>
    Array.from(
        { length: Math.floor((end - start) / step) + 1 },
        (_, i) => start + i * step,
    );
