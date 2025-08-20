import { InertiaPageProps } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

/**
 * Composable for retrieving a flash message by its key from Inertia page props
 * @param key - The flash key to look up in the flash object
 * @returns A computed string of the flash message, or undefined if not present
 */
export function useFlash(key: string) {
    const page = usePage<{ props: InertiaPageProps }>();
    return computed<string | undefined>(() => {
      const flashes = page.props.flash;
      if (!flashes || !Object.prototype.hasOwnProperty.call(flashes, key)) {
        return undefined;
      }

      return (flashes as Record<string, string | undefined>)[key];
    });
  }
