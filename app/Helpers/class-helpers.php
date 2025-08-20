<?php

if (!function_exists('border_class')) {
    function border_class($color)
    {
        $classes = [
            'primary' => 'border-primary',
            'secondary' => 'border-secondary',
            'red' => 'border-red',
            'blue' => 'border-blue',
            'green' => 'border-green',
            'yellow' => 'border-yellow',
            'pink' => 'border-pink',
            'purple' => 'border-purple',
            'indigo' => 'border-indigo',
            'gray' => 'border-gray',
            'orange' => 'border-orange',
            'teal' => 'border-teal',
            'cyan' => 'border-cyan',
            'lime' => 'border-lime',
            'amber' => 'border-amber',
            'emerald' => 'border-emerald',
            'fuchsia' => 'border-fuchsia',
            'rose' => 'border-rose',
            'sky' => 'border-sky',
            'slate' => 'border-slate',
            'zinc' => 'border-zinc',
            'neutral' => 'border-neutral',
            'stone' => 'border-stone',
        ];
        return data_get($classes, $color, '');
    }
}
if (!function_exists('bg_class')) {
    function bg_class($color)
    {
        $classes = [
            'primary' => 'border-primary',
            'secondary' => 'border-secondary',
            'red' => 'border-red',
            'blue' => 'border-blue',
            'green' => 'border-green',
            'yellow' => 'border-yellow',
            'pink' => 'border-pink',
            'purple' => 'border-purple',
            'indigo' => 'border-indigo',
            'gray' => 'border-gray',
            'orange' => 'border-orange',
            'teal' => 'border-teal',
            'cyan' => 'border-cyan',
            'lime' => 'border-lime',
            'amber' => 'border-amber',
            'emerald' => 'border-emerald',
            'fuchsia' => 'border-fuchsia',
            'rose' => 'border-rose',
            'sky' => 'border-sky',
            'slate' => 'border-slate',
            'zinc' => 'border-zinc',
            'neutral' => 'border-neutral',
            'stone' => 'border-stone',
        ];
        return data_get($classes, $color, '');
    }
}

if (!function_exists('text_class')) {
    function text_class($color)
    {
        $classes = [
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'red' => 'text-red',
            'blue' => 'text-blue',
            'green' => 'text-green',
            'yellow' => 'text-yellow',
            'pink' => 'text-pink',
            'purple' => 'text-purple',
            'indigo' => 'text-indigo',
            'gray' => 'text-gray',
            'orange' => 'text-orange',
            'teal' => 'text-teal',
            'cyan' => 'text-cyan',
            'lime' => 'text-lime',
            'amber' => 'text-amber',
            'emerald' => 'text-emerald',
            'fuchsia' => 'text-fuchsia',
            'rose' => 'text-rose',
            'sky' => 'text-sky',
            'slate' => 'text-slate',
            'zinc' => 'text-zinc',
            'neutral' => 'text-neutral',
            'stone' => 'text-stone',
        ];
        return data_get($classes, $color, '');
    }
}
