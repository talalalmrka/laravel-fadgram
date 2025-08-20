<?php

use App\ShareButton;

if (!function_exists('share_text_class')) {
    function share_text_class($id)
    {
        $classes = [
            'instagram' => 'text-instagram',
            'snapchat' => 'text-snapchat',
            'telegram' => 'text-telegram',
            'pinterest' => 'text-pinterest',
            'tiktok' => 'text-tiktok',
            'linkedin' => 'text-linkedin',
            'whatsapp' => 'text-whatsapp',
            'twitter' => 'text-twitter',
            'facebook' => 'text-facebook',
        ];
        return data_get($classes, $id, '');
    }
}
if (!function_exists('share_bg_class')) {
    function share_bg_class($id)
    {
        $classes = [
            'instagram' => 'bg-instagram',
            'snapchat' => 'bg-snapchat',
            'telegram' => 'bg-telegram',
            'pinterest' => 'bg-pinterest',
            'tiktok' => 'bg-tiktok',
            'linkedin' => 'bg-linkedin',
            'whatsapp' => 'bg-whatsapp',
            'twitter' => 'bg-twitter',
            'facebook' => 'bg-facebook',
        ];
        return data_get($classes, $id, '');
    }
}
if (!function_exists('share_button_class')) {
    function share_button_class($id)
    {
        $classes = [
            'instagram' => 'btn-instagram',
            'snapchat' => 'btn-snapchat',
            'telegram' => 'btn-telegram',
            'pinterest' => 'btn-pinterest',
            'tiktok' => 'btn-tiktok',
            'linkedin' => 'btn-linkedin',
            'whatsapp' => 'btn-whatsapp',
            'twitter' => 'btn-twitter',
            'facebook' => 'btn-facebook',
        ];
        return data_get($classes, $id, '');
    }
}
if (!function_exists('share_url')) {
    function share_url($url, $post)
    {
        return str_ireplace(
            [
                '{name}',
                '{excerpt}',
                '{permalink}',
                '{content}',
            ],
            [
                data_get($post, 'name', ''),
                data_get($post, 'excerpt', ''),
                data_get($post, 'permalink', ''),
                data_get($post, 'content', ''),
            ],
            $url
        );
    }
}

if (!function_exists('share_buttons')) {
    function share_buttons()
    {
        return ShareButton::enabled();
    }
}
