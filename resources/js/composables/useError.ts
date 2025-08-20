import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { InertiaPageProps } from '@/types';


/**
 * Composable for retrieving an error message by its key from Inertia page props
 * @param key - The error key to look up in the errors object
 * @returns A computed string of the first error message, or undefined if not present
 */
export function useError(key: string) {
  const page = usePage<{ props: InertiaPageProps }>();

  return computed<string | undefined>(() => {
    const errs = page.props.errors;
    if (!errs || !Object.prototype.hasOwnProperty.call(errs, key)) {
      return undefined;
    }

    const errorEntry = errs[key];

    // If it's an array, return the first message; if string, return it directly
    return Array.isArray(errorEntry) ? (errorEntry[0] || undefined) : errorEntry;
  });
}
