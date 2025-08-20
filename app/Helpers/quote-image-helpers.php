<?php

use App\Models\QuoteImage;

if (!function_exists('quote_image_options')) {
    function quote_image_options()
    {
        $query = QuoteImage::all();
        return $query->map(fn(QuoteImage $quoteImage) => [
            'label' => $quoteImage->image_name,
            'value' => $quoteImage->id,
            'image' => $quoteImage->image_url,
        ])->toArray();
    }
}

if (!function_exists('align_options')) {
    function align_options()
    {
        return [
            [
                'label' => __('Left'),
                'value' => 'left',
            ],
            [
                'label' => __('Center'),
                'value' => 'center',
            ],
            [
                'label' => __('Right'),
                'value' => 'right',
            ],
        ];
    }
}

if (!function_exists('align_values')) {
    function align_values()
    {
        return arr_map(align_options(), fn($option) => data_get($option, 'value'));
    }
}
if (!function_exists('valign_options')) {
    function valign_options()
    {
        return [
            [
                'label' => __('Top'),
                'value' => 'top',
            ],
            [
                'label' => __('Middle'),
                'value' => 'middle',
            ],
            [
                'label' => __('Bottom'),
                'value' => 'bottom',
            ],
        ];
    }
}

if (!function_exists('valign_values')) {
    function valign_values()
    {
        return arr_map(valign_options(), fn($option) => data_get($option, 'value'));
    }
}

if (!function_exists('image_format_options')) {
    function image_format_options()
    {
        return [
            [
                'label' => __('Jpg'),
                'value' => 'jpg',
            ],
            [
                'label' => __('Jpeg'),
                'value' => 'jpeg',
            ],
            [
                'label' => __('Jpeg 2000'),
                'value' => 'jpeg2000',
            ],
            [
                'label' => __('Png'),
                'value' => 'png',
            ],
            [
                'label' => __('Webp'),
                'value' => 'webp',
            ],
            [
                'label' => __('Avif'),
                'value' => 'avif',
            ],
            [
                'label' => __('Tiff'),
                'value' => 'tiff',
            ],
            [
                'label' => __('Gif'),
                'value' => 'gif',
            ],
            [
                'label' => __('Bitmap'),
                'value' => 'bitmap',
            ],
        ];
    }
}
if (!function_exists('image_format_values')) {
    function image_format_values()
    {
        return arr_map(image_format_options(), fn($option) => data_get($option, 'value'));
    }
}
