<?php

if (!function_exists('colors')) {
    function colors()
    {
        return [
            "white",
            "black",
            "red",
            "orange",
            "amber",
            "yellow",
            "lime",
            "green",
            "emerald",
            "teal",
            "cyan",
            "sky",
            "blue",
            "indigo",
            "violet",
            "purple",
            "fuchsia",
            "pink",
            "rose",
            "slate",
            "zinc",
            "neutral",
            "stone",
        ];
    }
}

if (!function_exists('color_options')) {
    function color_options(array $additional = [])
    {
        $ops = collect($additional);
        collect(colors())->each(function ($color) use (&$ops) {
            $ops->push([
                'label' => ucfirst($color),
                'value' => $color,
            ]);
        });
        return $ops->toArray();
    }
}
