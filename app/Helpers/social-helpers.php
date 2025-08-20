<?php

if (!function_exists('social_items')) {
    function social_items()
    {
        return [
            [
                'id' => 'instagram',
                'label' => __('Instagram'),
                'icon' => 'bi-instagram',
                'color' => '#E4405F',
                'share_enabled' => true,
            ],
            [
                'id' => 'snapchat',
                'label' => __('Snapchat'),
                'icon' => 'bi-snapchat',
                'color' => '#FFFC00',
                'share_enabled' => true,
            ],
            [
                'id' => 'telegram',
                'label' => __('Telegram'),
                'icon' => 'bi-telegram',
                'color' => '#24A1DE',
                'share_enabled' => true,
                'share_url' => 'https://t.me/share/url?url={permalink}',

            ],
            [
                'id' => 'pinterest',
                'label' => __('Pinterest'),
                'icon' => 'bi-pinterest',
                'color' => '#BD081C',
                'share_enabled' => true,
            ],
            [
                'id' => 'tiktok',
                'label' => __('Tiktok'),
                'icon' => 'bi-tiktok',
                'color' => '#EE1D51',
            ],
            [
                'id' => 'linkedin',
                'label' => __('LinkedIn'),
                'icon' => 'bi-linkedin-in',
                'color' => '#0A66C2',
                'share_url' => 'https://www.linkedin.com/shareArticle?url={permalink}',

            ],
            [
                'id' => 'whatsapp',
                'label' => __('Whatsapp'),
                'icon' => 'bi-whatsapp',
                'color' => '#25D366',
                'share_enabled' => true,
                'share_url' => 'https://wa.me/?text={permalink}',
            ],
            [
                'id' => 'youtube',
                'label' => __('Youtube'),
                'icon' => 'bi-youtube',
                'color' => '#CD201F',
            ],
            [
                'id' => 'twitter',
                'label' => __('Twitter'),
                'icon' => 'bi-twitter',
                'color' => '#1DA1F2',
                'share_url' => 'https://twitter.com/intent/tweet?url={permalink}',
            ],
            [
                'id' => 'facebook',
                'label' => __('Facebook'),
                'icon' => 'bi-facebook-f',
                'color' => '#1877F2',
                'share_url' => 'https://www.facebook.com/sharer/sharer.php?u={permalink}',
            ],
        ];
    }
}

if (!function_exists('social_options')) {
    function social_options()
    {
        return arr_map(social_items(), function ($item) {
            return [
                'label' => data_get($item, 'label'),
                'value' => data_get($item, 'id'),
                'icon' => data_get($item, 'icon'),
            ];
        });
    }
}

if (!function_exists('socials')) {
    function socials()
    {
        return arr_map(social_items(), function ($item) {
            return data_get($item, 'id');
        });
    }
}
if (!function_exists('social')) {
    function social($id)
    {
        $socials = collect(social_items());
        return $socials->where('id', $id)->first();
    }
}
if (!function_exists('social_icon')) {
    function social_icon($id)
    {
        $social = social($id);
        $icon = data_get($social, 'icon');
        return $social ? ($icon ? $icon : "bi-$id") : null;
    }
}
if (!function_exists('social_color')) {
    function social_color($id)
    {
        $social = social($id);
        return data_get($social, 'color', 'secondary');
    }
}
if (!function_exists('social_label')) {
    function social_label($id)
    {
        $social = social($id);
        return data_get($social, 'label', '');
    }
}
if (!function_exists('social_url')) {
    function social_url($id)
    {
        return get_option("social_{$id}");
    }
}
