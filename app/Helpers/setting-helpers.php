<?php

use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use Database\Seeders\SettingSeeder;


if (!function_exists('setting')) {
    function setting(String|int $id): Setting|null
    {
        if (is_numeric($id)) {
            return Setting::find($id);
        } elseif (is_string($id)) {
            return Setting::withKey($id);
        }
        return null;
    }
}
if (!function_exists('get_option')) {
    function get_option($key, $defaultValue = null)
    {
        return Setting::getValue($key, $defaultValue);
    }
}

if (!function_exists('update_option')) {
    function update_option(string $key, mixed $value, $type = null): bool
    {
        return Setting::updateValue($key, $value, $type);
    }
}
if (!function_exists('get_option_previews')) {
    function get_option_previews(string $key, $temporary = null)
    {
        return Setting::getPreviews($key, $temporary);
    }
}
if (!function_exists('get_option_type')) {
    function get_option_type(string $key)
    {
        $default_type = get_default_option_type($key);
        return Setting::getType($key, $default_type);
    }
}
if (!function_exists('get_default_option')) {
    function get_default_option(string $key, $defaultValue = null)
    {
        return SettingSeeder::getDefaultOption($key, $defaultValue);
    }
}
if (!function_exists('get_default_option_type')) {
    function get_default_option_type(string $key, $defaultValue = null)
    {
        return SettingSeeder::getDefaultOptionType($key, $defaultValue);
    }
}

if (!function_exists('resolve_option_value')) {
    function resolve_option_value($type, $value)
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'array' => is_json($value) ? json_decode($value, true) : (is_array($value) ? $value : []),
            'number' => !empty($value) ? intval($value) : $value,
            default => $value,
        };
    }
}

if (!function_exists('setting_type_options')) {
    function setting_type_options()
    {
        return [
            [
                'label' => __('Text'),
                'value' => 'text',
            ],
            [
                'label' => __('Textarea'),
                'value' => 'textarea',
            ],
            [
                'label' => __('Checkbox'),
                'value' => 'checkbox',
            ],
        ];
    }
}

if (!function_exists('setting_types')) {
    function setting_types()
    {
        return arr_map(setting_type_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}
if (!function_exists('front_type_options')) {
    function front_type_options()
    {
        return [
            [
                'label' => __('Your latest posts'),
                'value' => 'posts',
            ],
            [
                'label' => __('A static page'),
                'value' => 'page',
            ],
        ];
    }
}
if (!function_exists('front_types')) {
    function front_types()
    {
        return arr_map(front_type_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}
if (!function_exists('site_name')) {
    function site_name()
    {
        return get_option('name', config('app.name'));
    }
}
if (!function_exists('site_description')) {
    function site_description()
    {
        return get_option('description', config('app.description'));
    }
}
if (!function_exists('favicon')) {
    function favicon()
    {
        $setting = setting('favicon');
        return $setting ? $setting->getFirstMediaUrl('favicon') : null;
    }
}

if (!function_exists('logo')) {
    function logo()
    {
        $setting = setting('logo');
        return $setting ? $setting->getFirstMediaUrl('logo') : null;
    }
}
if (!function_exists('logo_light')) {
    function logo_light()
    {
        $setting = setting('logo_light');
        return $setting ? $setting->getFirstMediaUrl('logo_light') : null;
    }
}
if (!function_exists('logo_path')) {
    function logo_path()
    {
        $setting = setting('logo');
        return $setting ? $setting->getFirstMedia('logo')?->getPath() : null;
    }
}
if (!function_exists('logo_light_path')) {
    function logo_light_path()
    {
        $setting = setting('logo_light');
        return $setting ? $setting->getFirstMedia('logo_light')?->getPath() : null;
    }
}

if (!function_exists('front_page')) {
    function front_page(): Post | null
    {
        $front_page_id = get_option('front_page');
        return $front_page_id && is_numeric($front_page_id) ? Post::where('type', 'page')->find($front_page_id) : null;
    }
}
