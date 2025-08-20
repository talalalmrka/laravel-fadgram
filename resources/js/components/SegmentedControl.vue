<!-- SegmentedControl.vue -->
<script setup lang="ts">
import { OptionType } from '@/types';
import { computed, ref, watch, onMounted, nextTick } from 'vue';

/* type OptionValue = string | number | boolean;
type Option = {
    value: OptionValue;
    label: string;
    disabled?: boolean;
}; */

const props = defineProps<{
    modelValue: any;
    options: OptionType[];
    id?: string;
    name?: string;
    label?: string;
    hint?: string;
    error?: string;
    required?: boolean;
    disabled?: boolean;
    size?: 'sm' | 'md' | 'lg';
    class?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: any): void;
    (e: 'change', value: any): void;
}>();

const groupId = computed(() => props.id ?? `seg-${Math.random().toString(36).slice(2, 9)}`);
const size = computed(() => props.size ?? 'md');

const isDisabledAll = computed(() => !!props.disabled);
const selectedIndex = computed(() => props.options.findIndex(o => o.value === props.modelValue));

const btnRefs = ref<HTMLElement[]>([]);

watch(() => props.modelValue, async () => {
    await nextTick();
    // keep focus on the currently selected if any
    const el = btnRefs.value[selectedIndex.value];
    if (el && document.activeElement && (document.activeElement as HTMLElement).dataset.group === groupId.value) {
        el.focus({ preventScroll: true });
    }
});

function selectAt(index: number) {
    const opt = props.options[index];
    if (!opt || opt.disabled || isDisabledAll.value) return;
    emit('update:modelValue', opt.value);
    emit('change', opt.value);
}

function onKeydown(e: KeyboardEvent) {
    if (props.options.length === 0) return;

    const max = props.options.length - 1;
    let next = selectedIndex.value;

    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        e.preventDefault();
        do {
            next = (next + 1) > max ? 0 : next + 1;
        } while (props.options[next]?.disabled && next !== selectedIndex.value);
        selectAt(next);
        btnRefs.value[next]?.focus();
    } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        e.preventDefault();
        do {
            next = (next - 1) < 0 ? max : next - 1;
        } while (props.options[next]?.disabled && next !== selectedIndex.value);
        selectAt(next);
        btnRefs.value[next]?.focus();
    } else if (e.key === 'Home') {
        e.preventDefault();
        next = 0;
        while (props.options[next]?.disabled && next < max) next++;
        selectAt(next);
        btnRefs.value[next]?.focus();
    } else if (e.key === 'End') {
        e.preventDefault();
        next = max;
        while (props.options[next]?.disabled && next > 0) next--;
        selectAt(next);
        btnRefs.value[next]?.focus();
    } else if (e.key === ' ' || e.key === 'Enter') {
        e.preventDefault();
        // space/enter handled by click naturally on focused button, but ensure:
        const idx = btnRefs.value.findIndex(el => el === document.activeElement);
        if (idx >= 0) selectAt(idx);
    }
}

const baseSize = computed(() => {
    switch (size.value) {
        case 'sm':
            return { pad: 'px-2 py-1', text: 'text-sm', gap: 'gap-1', radius: 'rounded-xl' };
        case 'lg':
            return { pad: 'px-4 py-2', text: 'text-base', gap: 'gap-2', radius: 'rounded-2xl' };
        default:
            return { pad: 'px-3 py-1.5', text: 'text-sm', gap: 'gap-1.5', radius: 'rounded-2xl' };
    }
});

const groupClasses = computed(() => [
    'inline-flex',
    'items-stretch',
    'relative',
    'isolate',
    'rounded-2xl',
    'p-1',
    'bg-gray-100',
    'dark:bg-gray-800',
    'border',
    'border-gray-200',
    'dark:border-gray-700',
    isDisabledAll.value ? 'opacity-60 cursor-not-allowed select-none' : 'cursor-pointer',
    props.class ?? ''
].join(' '));

const knobStyle = computed(() => {
    // Used only for a “sliding” selected background via CSS variables
    const idx = Math.max(0, selectedIndex.value);
    const count = Math.max(1, props.options.length);
    return {
        '--seg-count': String(count),
        '--seg-index': String(idx),
    } as Record<string, string>;
});

onMounted(() => {
    // init refs length
    btnRefs.value = btnRefs.value.slice(0, props.options.length);
});
</script>

<template>
    <div class="space-y-2">
        <label v-if="label" :for="groupId" class="block font-medium text-gray-800 dark:text-gray-100">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>

        <!-- Segmented Group -->
        <div :id="groupId" role="radiogroup" :aria-disabled="isDisabledAll || undefined" :class="groupClasses"
            :style="knobStyle" @keydown="onKeydown">
            <!-- Sliding background (CSS trick using absolute element) -->
            <div aria-hidden="true" class="absolute inset-y-1 transition-all duration-200 ease-out rounded-xl bg-primary text-white shadow
               dark:bg-gray-900" :style="{
                width: `calc((100% - 0px) / ${props.options.length || 1})`,
                transform: `translateX(calc(${Math.max(0, selectedIndex)} * (100%)))`
            }" />

            <!-- Options -->
            <button v-for="(opt, i) in options" :key="String(opt.value)" ref="btnRefs" :data-group="groupId"
                role="radio" type="button" :aria-checked="modelValue === opt.value"
                :aria-disabled="isDisabledAll || opt.disabled || undefined"
                :tabindex="modelValue === opt.value ? 0 : -1" :disabled="isDisabledAll || opt.disabled"
                @click="selectAt(i)" class="relative z-10 select-none" :class="[
                    'focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 ring-offset-transparent',
                    'focus-visible:ring-gray-400 dark:focus-visible:ring-gray-600',
                    baseSize.pad, baseSize.text, baseSize.gap, baseSize.radius,
                    'min-w-[3rem] text-center',
                    (isDisabledAll || opt.disabled) ? 'cursor-not-allowed' : 'cursor-pointer',
                    modelValue === opt.value ? 'text-white' : '',
                ]">
                <!-- Default content OR slot -->
                <slot name="option" :option="opt" :checked="modelValue === opt.value" :index="i">
                    <span class="relative inline-flex items-center justify-center" :class="[baseSize.gap]">
                        <span class="whitespace-nowrap">
                            <fg-icon v-if="opt.icon" :icon="opt.icon" />
                            <span v-if="opt.label">{{ opt.label }}</span>

                        </span>
                    </span>
                </slot>

                <!-- Visually hidden native radio for forms (optional but useful) -->
                <input class="sr-only" type="radio" :name="name || groupId" :value="String(opt.value)"
                    :checked="modelValue === opt.value" :disabled="isDisabledAll || opt.disabled" @change.stop />
            </button>
        </div>

        <!-- Hint / Error -->
        <p v-if="hint && !error" class="text-xs text-gray-500">{{ hint }}</p>
        <p v-if="error" class="text-xs text-red-600">{{ error }}</p>
    </div>
</template>
