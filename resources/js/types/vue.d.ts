import { ComponentCustomProperties } from 'vue';
import { useMessages } from '../composables/useMessages';

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $getErrorMessage: typeof useMessages.prototype.getErrorMessage;
    $getFlashMessage: typeof useMessages.prototype.getFlashMessage;
  }
}