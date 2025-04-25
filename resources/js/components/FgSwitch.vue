<script setup lang="ts">
import { ref, computed } from 'vue';
//import FgInfo from './FgInfo.vue';
//import FgError from './FgError.vue';
import { FgInfo, FgError } from 'fadgram-vue';
defineOptions({ inheritAttrs: false });

const props = defineProps<{
  id?: string;
  icon?: string | null;
  label?: string;
  info?: string;
  error?: string;
  value?: any;
  uncheckedValue?: any;
  modelValue?: any;
  disabled?: boolean;
}>();
const emits = defineEmits<{
  (e: 'update:modelValue', val: any): void;
}>();

const fieldId = ref(props.id || `toggle-${Math.random().toString(36).substr(2, 9)}`);
const toggleRef = ref<HTMLInputElement | null>(null);
const isFlex = computed(() => props.icon && props.label);

defineExpose({ toggleRef });

const isChecked = computed(() => {
  if (Array.isArray(props.modelValue)) {
    // Group mode: check if value exists in array
    return props.value !== undefined && props.modelValue.includes(props.value);
  }
  if (props.value !== undefined) {
    // Single value mode: compare with modelValue
    return props.modelValue === props.value;
  }
  // Default boolean mode
  return Boolean(props.modelValue);
});

function update(checked: boolean) {
  let newValue: any;

  if (Array.isArray(props.modelValue)) {
    // Group array logic
    newValue = [...props.modelValue];
    if (checked) {
      if (!newValue.includes(props.value)) {
        newValue.push(props.value);
      }
    } else {
      newValue = newValue.filter((item: any) => item !== props.value);
    }
  } else if (props.value !== undefined) {
    // Single value mode
    newValue = checked ? props.value : props.uncheckedValue;
  } else {
    // Default boolean toggle
    newValue = !props.modelValue;
  }

  emits('update:modelValue', newValue);
}
</script>
<template>
  <label :for="fieldId" class="form-switch" :class="{ 'error': error }">
    <input ref="toggleRef" v-bind="$attrs" type="checkbox" :id="fieldId" :checked="isChecked" :disabled="disabled"
      @change="update(($event.currentTarget as HTMLInputElement).checked)" />
    <span class="toggle-slider"></span>
    <span class="form-switch-label" :class="{ 'flex-space-2': isFlex }">
      <i v-if="icon" class="icon" :class="icon"></i>
      <span v-if="label">{{ label }}</span>
    </span>
  </label>
  <FgInfo :info="info" />
  <FgError :error="error" />
</template>