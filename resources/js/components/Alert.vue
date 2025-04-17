<script setup lang="ts">
import { computed, useAttrs, useSlots } from 'vue';

type AlertType =
    | 'info'
    | 'success'
    | 'error'
    | 'warning'
    | 'primary'
    | 'secondary'
    | 'accent'
    | 'neutral'
    | 'base'
    | 'light'
    | 'dark'
    | 'blue'
    | 'indigo'
    | 'purple'
    | 'pink'
    | 'red'
    | 'orange'
    | 'yellow'
    | 'green'
    | 'teal'
    | 'cyan'
    | 'gray'
    | 'slate'
    | 'zinc'
    | 'stone'
    | 'amber'
    | 'lime'
    | 'emerald'
    | 'sky'
    | 'violet'
    | 'fuchsia'
    | 'rose';

const props = defineProps({
    class: {
        type: String,
        default: null,
    },
    atts: {
        type: Object,
        default: () => ({}),
    },
    type: {
        type: String as () => AlertType,
        default: 'info',
    },
    soft: {
        type: Boolean,
        default: false,
    },
    outline: {
        type: Boolean,
        default: false,
    },
    size: {
        type: String,
        default: null,
    },
    icon: {
        type: String,
        default: null,
    },
    iconClass: {
        type: String,
        default: null,
    },
    content: {
        type: String,
        default: null,
    },
    hideIcon: {
        type: Boolean,
        default: false,
    },
});

const attrs = useAttrs();
const slots = useSlots();

const types = {
    info: 'alert-info',
    success: 'alert-success',
    error: 'alert-error',
    warning: 'alert-warning',
    primary: 'alert-primary',
    secondary: 'alert-secondary',
    accent: 'alert-accent',
    neutral: 'alert-neutral',
    base: 'alert-base',
    light: 'alert-light',
    dark: 'alert-dark',
    blue: 'alert-blue',
    indigo: 'alert-indigo',
    purple: 'alert-purple',
    pink: 'alert-pink',
    red: 'alert-red',
    orange: 'alert-orange',
    yellow: 'alert-yellow',
    green: 'alert-green',
    teal: 'alert-teal',
    cyan: 'alert-cyan',
    gray: 'alert-gray',
    slate: 'alert-slate',
    zinc: 'alert-zinc',
    stone: 'alert-stone',
    amber: 'alert-amber',
    lime: 'alert-lime',
    emerald: 'alert-emerald',
    sky: 'alert-sky',
    violet: 'alert-violet',
    fuchsia: 'alert-fuchsia',
    rose: 'alert-rose',
} as const;

const icons = {
    info: 'bi-info-circle',
    success: 'bi-check-circle',
    warning: 'bi-exclamation-triangle',
    error: 'bi-x-circle',
} as const;

const iconClassName = computed(() => {
    if (props.hideIcon) return null;
    return props.icon ?? icons[props.type];
});

const hasIcon = computed(() => !!iconClassName.value);

const mergedAttrs = computed(() => {
    const { class: _, ...restAttrs } = attrs;
    const { class: __, ...restAtts } = props.atts;
    return { ...restAttrs, ...restAtts };
});

const rootClasses = computed(() => [
    'alert',
    types[props.type],
    props.size,
    {
        'flex-space-2': hasIcon.value,
        'alert-soft': props.soft,
        'alert-outline': props.outline,
    },
    props.class,
    attrs.class,
    props.atts.class,
]);

const hasContent = computed(() => !!slots.default || !!props.content);
</script>

<template>
    <div :class="rootClasses" v-bind="mergedAttrs">
        <i v-if="iconClassName" :class="['icon', iconClassName, props.iconClass]" />
        <div v-if="hasContent" class="grow">
            <slot v-if="$slots.default" />
            <div v-else v-html="content" />
        </div>
    </div>
</template>
