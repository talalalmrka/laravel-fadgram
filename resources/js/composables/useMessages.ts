import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

interface PageProps {
  [key: string]: unknown;
  errors?: Record<string, string | string[]>;
  flash?: Record<string, string | undefined>;
}

export const useMessages = () => {
  const page = usePage<PageProps>();

  const getErrorMessage = (key: string): string | null => {
    const error = page.props.errors?.[key];
    return typeof error === 'string' ? error : error?.[0] || null;
  };

  const getFlashMessage = (key: string): string | null => {
    return page.props.flash?.[key] || null;
  };

  return {
    getErrorMessage,
    getFlashMessage,
  };
};