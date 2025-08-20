<?php

use App\Models\Font;
use Illuminate\Support\Arr;

if (!function_exists('font_family_options')) {
    function font_family_options()
    {
        $fonts = Font::enabled();
        $options = [
            [
                'label' => __('Sans serif'),
                'value' => 'sans',
            ],
        ];
        foreach ($fonts as $font) {
            $options[] = [
                'label' => $font->name,
                'value' => $font->slug,
            ];
        }

        return $options;
    }
}

if (!function_exists('font_families')) {
    function font_families()
    {
        return Arr::map(font_family_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}
if (!function_exists('font_smoothing_options')) {
    function font_smoothing_options()
    {
        return [
            [
                'label' => __('Default'),
                'value' => '',
            ],
            [
                'label' => __('antialiased'),
                'value' => 'antialiased',
            ],
            [
                'label' => __('subpixel-antialiased'),
                'value' => 'subpixel-antialiased',
            ],
        ];
    }
}

if (!function_exists('font_smoothings')) {
    function font_smoothings()
    {
        return Arr::map(font_smoothing_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}

if (!function_exists('font_size_options')) {
    function font_size_options()
    {
        return [
            [
                'label' => __('Default'),
                'value' => '',
            ],
            [
                'label' => __('2xs'),
                'value' => '2xs',
            ],
            [
                'label' => __('xs'),
                'value' => 'xs',
            ],
            [
                'label' => __('sm'),
                'value' => 'sm',
            ],
            [
                'label' => __('base'),
                'value' => 'base',
            ],
            [
                'label' => __('lg'),
                'value' => 'lg',
            ],
            [
                'label' => __('xl'),
                'value' => 'xl',
            ],
            [
                'label' => __('2xl'),
                'value' => '2xl',
            ],
            [
                'label' => __('3xl'),
                'value' => '3xl',
            ],
            [
                'label' => __('4xl'),
                'value' => '4xl',
            ],
            [
                'label' => __('5xl'),
                'value' => '5xl',
            ],
            [
                'label' => __('6xl'),
                'value' => '6xl',
            ],
            [
                'label' => __('7xl'),
                'value' => '7xl',
            ],
            [
                'label' => __('8xl'),
                'value' => '8xl',
            ],
            [
                'label' => __('9xl'),
                'value' => '9xl',
            ],
        ];
    }
}

if (!function_exists('font_sizes')) {
    function font_sizes()
    {
        return Arr::map(font_size_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}

if (!function_exists('font_style_options')) {
    function font_style_options()
    {
        return [
            [
                'label' => __('Normal'),
                'value' => 'normal',
            ],
            [
                'label' => __('Italic'),
                'value' => 'italic',
            ],
            [
                'label' => __('Oblique'),
                'value' => 'oblique',
            ],

        ];
    }
}

if (!function_exists('font_styles')) {
    function font_styles()
    {
        return Arr::map(font_style_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}

if (!function_exists('font_weight_options')) {
    function font_weight_options()
    {
        return [
            [
                'label' => __('Normal'),
                'value' => 'normal',
            ],
            [
                'label' => __('Bold'),
                'value' => 'bold',
            ],
            [
                'label' => '100',
                'value' => '100',
            ],
            [
                'label' => '200',
                'value' => '200',
            ],
            [
                'label' => '300',
                'value' => '300',
            ],
            [
                'label' => '400',
                'value' => '400',
            ],
            [
                'label' => '500',
                'value' => '500',
            ],
            [
                'label' => '600',
                'value' => '600',
            ],
            [
                'label' => '700',
                'value' => '700',
            ],
            [
                'label' => '800',
                'value' => '800',
            ],
            [
                'label' => '900',
                'value' => '900',
            ],
        ];
    }
}

if (!function_exists('font_weights')) {
    function font_weights()
    {
        return Arr::map(font_weight_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}

if (!function_exists('font_display_options')) {
    function font_display_options()
    {
        return [
            [
                'label' => __('Auto'),
                'value' => 'auto',
            ],
            [
                'label' => __('Block'),
                'value' => 'block',
            ],
            [
                'label' => __('Swap'),
                'value' => 'swap',
            ],
            [
                'label' => __('Fallback'),
                'value' => 'fallback',
            ],
            [
                'label' => __('Optional'),
                'value' => 'optional',
            ],
        ];
    }
}

if (!function_exists('font_displays')) {
    function font_displays()
    {
        return Arr::map(font_display_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}

if (!function_exists('font_options')) {
    function font_options()
    {
        $query = Font::all();
        return $query->map(fn(Font $font) => [
            'label' => $font->name,
            'value' => $font->id,
        ])->toArray();
    }
}
